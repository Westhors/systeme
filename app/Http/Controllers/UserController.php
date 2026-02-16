<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\LogResource;
use App\Http\Resources\UserIndexResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Mail\UserMail;
use App\Mail\UserRequestMail;
use App\Models\ContactPeople;
use App\Models\EmailTemplate;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    protected mixed $crudRepository;

    public function __construct(UserRepositoryInterface $pattern)
    {
        $this->crudRepository = $pattern;
    }

    public function index()
    {
        try {
            $user = UserResource::collection($this->crudRepository->all(
                [],
                [],
                ['*']
            ));
            return $user->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function show(User $user): ?\Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponse::respondSuccess('Item fetched successfully', new UserResource($user));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function update(UserRequest $request, User $user)
    {
        try {
            $this->crudRepository->update($request->validated(), $user->id);
            if (request('image') !== null) {
                $user = User::find($user->id);
                $image = $this->crudRepository->AddMediaCollection('image', $user);
            }
            activity()->performedOn($user)->withProperties(['attributes' => $user])->log('update');
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function applicationForm(UserRequest $request)
    {
        try {
            $user = $this->crudRepository->create($request->validated());
            if ($request->contact_persons) {
                foreach ($request->contact_persons as $contactPersonData) {
                    if (ContactPeople::where('user_id', $user->id)->where('email', $contactPersonData['email'])->exists()) {
                        return JsonResponse::respondError("The email {$contactPersonData['email']} has already been taken for this user.");
                    }
                    $contactPerson = $user->contactPersons()->create($contactPersonData);
                    $contactPersonId = $contactPerson->id;
                    DB::table('mediable')->insert([
                        "model_id" => $contactPersonId,
                        "model_type" => 'App\Models\ContactPeople',
                        "media_id" => $contactPersonData['image'],
                        "collection" => 'default',
                    ]);
                    DB::table('mediable')->insert([
                        "model_id" => $contactPersonId,
                        "model_type" => 'App\Models\ContactPeople',
                        "media_id" => $contactPersonData['passport'],
                        "collection" => 'passport',
                    ]);
                }
            }

            $randomPassword = Str::random(12);
            DB::table('users')->where('id', $user->id)->update([
                'password' => Hash::make($randomPassword),
                'unhashed_password' => $randomPassword,
            ]);

            if (request('image') !== null) {
                $this->crudRepository->AddMediaCollection('image', $user);
            }

            DB::table('users')->where('id', $user->id)->update(['ref_id' => $request->input('ref')]);

            try {
                $template = DB::table('email_templates')->where('slug', 'new_application_confirmation_email_template')->value('body');
                $subject = DB::table('email_templates')->where('slug', 'new_application_confirmation_email_template')->value('subject');
                Mail::to($user->email)->queue(new UserRequestMail($template, $subject));

                $emails = EmailTemplate::where('slug', 'new_application_confirmation_email_template')->select('bcc')->first();
                $emails_bcc = explode(',', $emails?->bcc);
                foreach ($emails_bcc as $email) {
                    Mail::to($email)->queue(new UserMail($user));
                }
            } catch (Exception $e) {
                Log::error('Error sending application form emails: ' . $e->getMessage(), ['context' => $e]);
                JsonResponse::respondError($e->getMessage());
            }

            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_ADDED_SUCCESSFULLY_APPLICATION), new UserResource($user));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function destroy(Request $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecords('users', $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->restoreItem(User::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_RESTORED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

   public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // 🔹 البحث في جدول المستخدمين
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                $token = $user->createToken('auth_token')->plainTextToken;

                return JsonResponse::respondSuccess([
                    'type' => 'user',
                    'access_token' => $token,
                    'data' => new UserResource($user),
                ]);
            }

            // 🔹 البحث في جدول الموظفين
            $employee = Employee::where('email', $request->email)->first();

            if ($employee && Hash::check($request->password, $employee->password)) {

                $token = $employee->createToken('auth_token')->plainTextToken;

                return JsonResponse::respondSuccess([
                    'type' => 'employee',
                    'access_token' => $token,
                    'data' => new EmployeeResource($employee),
                ]);
            }

            return JsonResponse::respondError('The provided credentials are incorrect.');

        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function forceDelete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->crudRepository->deleteRecordsFinial(User::class, $request['items']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_FORCE_DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return JsonResponse::respondSuccess([], 'Successfully logged out');
    }



    public function logIndex(Request $request)
    {
        $query = DB::table('activity_log')->orderByDesc('id');
        $from = $request->input('from');
        $to = $request->input('to');
        $perPage = $request->input('per_page', 15);
        if ($from && $to) {
            $fromDate = \Carbon\Carbon::parse($from)->startOfDay();
            $toDate = \Carbon\Carbon::parse($to)->endOfDay();

            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        $log = $query->paginate($perPage);
        return LogResource::collection($log);
    }


    public function totalCountPerCountry(Request $request)
    {
        try {
            $userCountByCountry = DB::table('countries')
                ->select(
                    'countries.name as country_name',
                    DB::raw('COUNT(users.id) as user_count')
                )
                ->join('users', 'countries.id', '=', 'users.country_id')
                ->whereNull('users.deleted_at')
                ->groupBy('countries.name')
                ->get();

            $result = [];

            foreach ($userCountByCountry as $country) {
                $result[] = [
                    'country_name' => $country->country_name,
                    'user_count' => $country->user_count,
                ];
            }

            return $result;
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function indexPublic()
    {
        try {
            $data = User::where('active', true)
                ->where('show_home', true)
                ->get();
            return UserIndexResource::collection($data)->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function indexActive()
    {
        try {
            $data = User::where('active', true)
                ->get();
            return UserIndexResource::collection($data)->additional(JsonResponse::success());
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
