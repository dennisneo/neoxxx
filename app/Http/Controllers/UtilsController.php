<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 7/27/2016
 * Time: 10:20 AM
 */

namespace App\Http\Controllers;

use App\Http\Models\Locations\Countries;
use App\Models\LearningGoals\LearningGoals;
use App\Models\Placement\QuestionChoices;
use App\Models\Placement\Questions;
use App\Models\Users\Applicant;
use App\Models\Users\User;
use App\Models\Users\UserEntity;
use Faker\Factory;
use Helpers\Html;
use Illuminate\Http\Request;

class UtilsController extends Controller{

    public function __construct()
    {

    }

    public function pwd()
    {
        /**
        $user  = UserEntity::find( 20 );
        $params = unserialize( $user->params );
        $pwd  = $user->getPassword( $params['pwd']);
         **/
        $pwd = 'arfarf';
        dd( \Hash::make( $pwd ) );

    }

    public function populateQuestions()
    {
        $lg_array = LearningGoals::all()->pluck('goal_id')->toArray() ;

        for( $i = 0 ; $i < 20 ; $i++ ){

            $faker =  Factory::create();
            $key = array_rand ( $lg_array , 1  );

            $q = new Questions;
            $q->question = $faker->paragraph;
            $q->cat_id   = $lg_array[ $key ] ;
            $q->added_at  = date('Y-m-d H:i:s');
            $q->save();

            $key = array_rand ( [0,1,2,3] , 1  );

            for( $n = 0 ; $n <  4 ; $n++ ){
                $c = new QuestionChoices();
                $c->choice = $faker->sentence;
                $c->q_id = $q->q_id;
                $c->is_answer = $n == $key ? 1 : 0;
                $c->added_at = date( 'Y-m-d H:i:s');
                $c->save();
            }

        }

        return 'OKKK';
    }
}