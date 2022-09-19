<?php

namespace App\Http\Controllers\Api;

use App\Events\PhotoUploadedEvent;
use App\Exceptions\UserWithThisDataAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Contracts\UsersRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public UsersRepositoryInterface $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index(IndexUserRequest $request): JsonResponse
    {

        $filterData = $request->only(['count', 'page', 'offset']);

        $usersData = $this->usersRepository->index($filterData);

        $data = new UsersCollection($usersData);


        // sending users to end of response ;)
        // TODO: fix this part
        $dataArray = $data->response($request)->getData(true);
        $users = $dataArray['users'];
        unset($dataArray['users']);
        $dataArray['users'] = $users;

        return apiFormatResponse(
            code: Response::HTTP_OK,
            data: $dataArray,
            status: true
        );
    }

    public function show(ShowUserRequest $request, $user_id): JsonResponse
    {
        $userData = $this->usersRepository->show($user_id);
        $data = UsersResource::make($userData);

        return apiFormatResponse(
            code: Response::HTTP_OK,
            data: $data,
            status: true
        );
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->checkStoreUserData($request->all());

        $data = $request->only([
            'name',
            'email',
            'phone',
            'position_id',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = $this->uploadUserPhoto($request->file('photo'));

            $data['photo'] = $photoName;
        }

        $userId = $this->usersRepository->create($data);

        return apiFormatResponse(
            data: [
                'user_id' => $userId,
                'message' => 'New user successfully registered',
            ],
            status: true,
        );
    }

    protected function checkStoreUserData($data)
    {
        if (
            User::query()->where('email', $data['email'])
            ->orWhere('phone', $data['phone'])
            ->exists()
        ) {
            throw new UserWithThisDataAlreadyExistsException();
        }
    }

    protected function uploadUserPhoto(UploadedFile $file)
    {
        $resultPath = Storage::disk('photos')->put('/', $file);

        $fullPath = Storage::disk('photos')->path($resultPath);

        event(new PhotoUploadedEvent($fullPath));

        return $resultPath;
    }
}
