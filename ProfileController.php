<?php


namespace App\Http\Mobile;


use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserProfile;
use App\Models\User\UserProfileEducation;
use App\Models\User\UserProfileEmployment;
use Illuminate\Http\Request;
use Storage;

class ProfileController extends Controller
{

    const TELEGRAM_TOKEN = '1573439744:AAGcK8NBsLcjTjHMmdIIWJG0fDkZVTk5Umg';
    const TELEGRAM_CHATID = '-1001440877537';

    public function show()
    {
        return UserProfile::whereUserId(auth()->user()->id)->with('education', 'employments')->first();
    }


    public function store(Request $request)
    {
        if (isset($request['educations'])) {
            $education = $request['educations'];
            $profile = UserProfile::whereUserId(auth()->user()->id)->first();
            $education[0]['user_id'] = auth()->user()->id;
            $education[0]['profile_id'] = $profile->id;
            return UserProfileEducation::updateOrCreate(['id'=>$education[0]['id']], $education[0]);

        }
        if (isset($request['employments'])) {
            $req = $request['employments'];
            $profile = UserProfile::whereUserId(auth()->user()->id)->first();
            $req[0]['user_id'] = auth()->user()->id;
            $req[0]['profile_id'] = $profile->id;
            return UserProfileEmployment::updateOrCreate(['id'=>$req[0]['id']], $req[0]);

        }

        return UserProfile::whereUserId(auth()->user()->id)->update($request->all());
    }

    public function avatar(Request $request)
    {
        return Storage::disk('public')->put(
            'avatars/' . auth()->user()->id . '.jpeg',
            file_get_contents($request->file('photo')->getRealPath())
        );
    }

    public function destroy($id,$field)
    {
       if($field == 'educations'){
           try {
               return UserProfileEducation::whereId($id)->delete();
           } catch (\Exception $e) {
               return $e;
           }
       } elseif ($field == 'employments'){
           try {
               return UserProfileEmployment::whereId($id)->delete();
           } catch (\Exception $e) {
               return $e;
           }
       }
    }

    public function notification(){

        $user = User::whereId(auth()->user()->id)->first();


        $this->telegramMessage('Новый кандидат '.$user->name.' '.$user->surname.'   <a href="http://194.87.232.56">ссылка на профиль</a>');

    }

    public function notificationUpdate(){

        $user = User::whereId(auth()->user()->id)->first();

        $this->telegramMessage('Кандидат '.$user->name.' '.$user->surname.'  обновил профиль  <a href="http://194.87.232.56">ссылка на профиль</a>');

    }
    protected function telegramMessage($text)
    {
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . self::TELEGRAM_TOKEN . '/sendMessage?parse_mode=HTML',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => self::TELEGRAM_CHATID,
                    'text' => $text,
                ),
            )
        );
        curl_exec($ch);
    }
}
