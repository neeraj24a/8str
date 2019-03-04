<?php

class DefaultController extends Controller {

    public $layout = '//layouts/home_main';

    public function actionIndex() {
        $this->render('index');
    }

    public function actionProfile() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $logged_in_user_id = Yii::app()->user->id;
            $user = Users::model()->find(array("condition" => "id = '$logged_in_user_id'"));
            $recommended_list = Users::model()->getRecommendList($logged_in_user_id);



            $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$logged_in_user_id' AND type='1' "));
            $shared_videos = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$logged_in_user_id' AND type='2' "));

            if (!empty($shared_songs)) {
                $shared_songs_ids = array();
                foreach ($shared_songs as $s) {
                    array_push($shared_songs_ids, "'$s->song_id'");
                }
                $ids = implode(',', $shared_songs_ids);
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='1' AND deleted = 0 AND"
                            . " ((created_by = '$logged_in_user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc")
                );
            } else {
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='1' AND deleted = 0 AND"
                            . " created_by = '$logged_in_user_id' ", "order" => "date_entered desc")
                );
            }



            if (!empty($shared_videos)) {
                $shared_videos_ids = array();
                foreach ($shared_videos as $s) {
                    array_push($shared_videos_ids, "'$s->song_id'");
                }
                $v_ids = implode(',', $shared_videos_ids);
                $video_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='2' AND deleted = 0 AND"
                            . " ((created_by = '$logged_in_user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc")
                );
            } else {
                $video_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='2' AND deleted = 0 AND"
                            . " created_by = '$logged_in_user_id' ", "order" => "date_entered desc")
                );
            }








            // $song_list = Songs::model()->findAll(array("condition" => "status = '1' AND type='1' AND deleted = 0 AND created_by = '$logged_in_user_id'    ", "order" => "date_entered desc", "limit" => 20));
            // $video_list = Songs::model()->findAll(array("condition" => "status = '1' AND type='2' AND deleted = 0 AND created_by = '$logged_in_user_id'    ", "order" => "date_entered desc", "limit" => 20));
            $total_track_list = count($song_list) + count($video_list);
            $following_list = Followers::model()->findAll(array("condition" => "follower_id = '$logged_in_user_id'"));
            $follow_unfollow = Followers::model()->find(array("condition" => " user_id = '$logged_in_user_id' AND follower_id = '$logged_in_user_id' "));
            if (!empty($follow_unfollow)) {
                if ($follow_unfollow->deleted == 0) {
                    $follow_unfollow_text = "Unfollow";
                } else if ($follow_unfollow->deleted == 1) {
                    $follow_unfollow_text = "Follow";
                }
            } else {
                $follow_unfollow_text = "Follow";
            }
            // pre($song_list,true);

            $this->render('profile', array(
                'user' => $user,
                'song_list' => $song_list,
                'video_list' => $video_list,
                'total_track_list' => $total_track_list,
                'following_list' => $following_list,
                'follow_unfollow_text' => $follow_unfollow_text,
                'recommended_list' => $recommended_list,
            ));
        }
    }

    public function actionEdit() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(base_url());
        } else {
            $logged_in_user_id = Yii::app()->user->id;
            $model = Users::model()->findByPk($logged_in_user_id);

            $this->render('edit', array('model' => $model));
        }
    }

    public function actionChangePassword() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(base_url());
        } else {
            $id = Yii::app()->user->id;
            $model = new ChangePassword;
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'changepass-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            $user = Users::model()->findByPk($id);
            if (isset($_POST['ChangePassword'])) {
                $model->attributes = $_POST['ChangePassword'];
                if ($model->validate()) {
                    $user->password = md5($model->password);
                    if ($user->validate()) {
                        $user->save();
                        Yii::app()->user->setFlash('success', "Password Changed Successfully");
                        $this->redirect(array("changepassword"));
                    }
                }
            }
            $this->render('change_password', array('model' => $model));
        }
    }

    public function actionDrive() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $logged_in_user_id = Yii::app()->user->id;

            $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$logged_in_user_id' "));

            if (!empty($shared_songs)) {
                $shared_songs_ids = array();
                foreach ($shared_songs as $s) {
                    array_push($shared_songs_ids, "'$s->song_id'");
                }
                $ids = implode(',', $shared_songs_ids);
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='1' AND deleted = 0 AND"
                            . " ((created_by = '$logged_in_user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc")
                );
            } else {
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='1' AND deleted = 0 AND"
                            . " created_by = '$logged_in_user_id' ", "order" => "date_entered desc")
                );
            }

            $genres = Genres::model()->findAll(array("condition" => "parent = '0'"));
            $this->render('drive', array('song_list' => $song_list, 'genres' => $genres, 'logged_in_user_id' => $logged_in_user_id));
        }
    }

    public function actionAjaxSongType() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $song_type = $_POST['song_type'];
            if ($song_type == 'audio') {
                $type = 1;
            } else if ($song_type == 'video') {
                $type = 2;
            }
            $logged_in_user_id = Yii::app()->user->id;

            $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$logged_in_user_id' "));

            if (!empty($shared_songs)) {
                $shared_songs_ids = array();
                foreach ($shared_songs as $s) {
                    array_push($shared_songs_ids, "'$s->song_id'");
                }
                $ids = implode(',', $shared_songs_ids);
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='$type' AND deleted = 0 AND"
                            . " ((created_by = '$logged_in_user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc")
                );
            } else {
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='$type' AND deleted = 0 AND"
                            . " created_by = '$logged_in_user_id' ", "order" => "date_entered desc")
                );
            }

            $this->renderPartial('ajax_drive', array('song_list' => $song_list, 'logged_in_user_id' => $logged_in_user_id));
        }
    }

    public function actionAjaxDrive() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $genre = $_POST['genre'];
            $song_type = $_POST['song_type'];
            if ($song_type == 'audio') {
                $type = 1;
            } else if ($song_type == 'video') {
                $type = 2;
            }
            $logged_in_user_id = Yii::app()->user->id;

            $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$logged_in_user_id' "));

            if (!empty($shared_songs)) {
                $shared_songs_ids = array();
                foreach ($shared_songs as $s) {
                    array_push($shared_songs_ids, "'$s->song_id'");
                }
                $ids = implode(',', $shared_songs_ids);
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='$type' AND genre='$genre' AND deleted = 0 AND"
                            . " ((created_by = '$logged_in_user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc")
                );
            } else {
                $song_list = Songs::model()->findAll(
                        array(
                            "condition" =>
                            "status = '1' AND type='$type' AND genre='$genre' AND deleted = 0 AND"
                            . " created_by = '$logged_in_user_id' ", "order" => "date_entered desc")
                );
            }


            $this->renderPartial('ajax_drive', array('song_list' => $song_list, 'logged_in_user_id' => $logged_in_user_id));
        }
    }

    public function actionSongDetail() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $song = $_POST['song'];
            $song_model = Songs::model()->findByPk($song);
            $this->renderPartial('ajax_edit_song', array('song_model' => $song_model));
            $script = Yii::app()->clientScript->scripts[CClientScript::POS_READY]['CActiveForm#song_edit_form'];
            echo "<script type='text/javascript'>$script</script>";
        }
    }

    public function actionEditSong($song) {
        $song_model = Songs::model()->findByPk($song);
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'song_edit_form') {
            echo CActiveForm::validate($song_model);
            Yii::app()->end();
        }
        if (isset($_POST['Songs'])) {
            $song_model->attributes = $_POST['Songs'];
            if ($song_model->validate()) {
                $song_model->save();
                $this->redirect(base_url() . '/user/drive');
            } else {
                pre($song_model->getErrors());
            }
        }
    }

    public function actionAjaxDelete() {
        if (Yii::app()->user->id) {
            $song = $_POST['song'];
            $song_detail = Songs::model()->findByPk($song);
            if (!empty($song_detail)) {

                // deleting from the downloads table
                Downloads::model()->deleteAll(array("condition" => "song_id = '$song_detail->id'"));

                // deleting from the song_like table
                SongLike::model()->deleteAll(array("condition" => "song_id = '$song_detail->id'"));

                // deleting from the playlist_songs table
                PlaylistSongs::model()->deleteAll(array("condition" => "song_id = '$song_detail->id'"));

                // deleting from song_share table

                $song_share = SongShare::model()->deleteAll(array("condition" => "song_id='$song_detail->id'"));

                // deleting from the amazon bucket
                $s3 = new AS3;
                $result = $s3->deleteSong($song_detail->s3_bucket, $song_detail->file_name);

                // deleting from the media table 
                $song_detail->delete();
                echo "success";
            } else {
                echo "failure";
            }
        }
    }

    public function actionPaymenthistory() {
        if (Yii::app()->user->id) {
            $model = new Transactions('search');
            $model->unsetAttributes();

            $this->render('payment_history', array(
                'model' => $model,
            ));
        } else {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    protected function gridPlan($data) {
        $plan = $data->plan_id;
        return Plans::model()->find(array("condition" => "stripe_plan = '$plan'"))->plan_name;
    }

    public function actionPlans() {

        $this->layout = '//layouts/payment_main';
        //$user = Yii::app()->session['register_user_info'];
        //$user = unserialize($user);
        //pre($user,true);
        $user_id = Yii::app()->user->id;
        $user_plan = UserPlan::model()->getUserActivePlan($user_id);

        $plans = BaseModel::getAll('Plans', array('order' => 'plan_serial ASC'));
        $this->render('plans', array('plans' => $plans, 'user_plan' => $user_plan));
    }

    public function actionForgotPassword() {

        $model = new ForgotPassword;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgotpassword-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // function to be hit after successfull validation of the model 
    public function actionAjaxForgotPassword() {
        $username = $_POST['username'];
        $user = Users::model()->find(array("condition" => " username = '$username' OR email = '$username' "));
        $return_array = array();
        if (empty($user)) {
            $return_array['status'] = "failure";
            $return_array['message'] = "Sorry We could not find any record";
        } else {
            // making entry in the user table the password_reset_code	

            $flag = $this->enterPasswordResetCode($user);
            if ($flag) {
                // sending password reset link email to the user


                $return_array['status'] = "success";
                $return_array['message'] = "We have sent you the password reset link. Please check your mail inbox";
            }
        }
        echo json_encode($return_array);
    }

    public function enterPasswordResetCode($user) {
        $password_reset_code = create_guid();
        $check_user = Users::model()->find(array("condition" => "password_reset_code = '$password_reset_code'"));
        if (!empty($check_user)) {
            $this->enterPasswordResetCode($user);
        } else {
            $user->password_reset_code = $password_reset_code;
            $user->save();
            return true;
        }
    }

    public function actionDownload($file) {

        $song_detail = Songs::model()->findByPk($file);
        $s3 = new AS3;
        $result = $s3->getSong($song_detail->s3_bucket, $song_detail->file_name);

        // try {
        // Display the object in the browser
        header("Content-Type: {$result['ContentType']}");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"$song_detail->file_name\"");
        // header('Content-Disposition: attachment; filename='.$song_detail->file_name);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $user_id = Yii::app()->user->id;
        $download_model = new Downloads;
        $download_model->user_id = $user_id;
        $download_model->song_id = $song_detail->id;
        $download_model->owner_id = $song_detail->created_by;
        $download_model->type = $song_detail->type;
        $download_model->save();
        ob_clean();
        flush();
        echo $result['Body'];
    }

    public function actionAjaxChangeFileMode() {
        if (Yii::app()->user->id) {
            $song = $_POST['song'];
            $song_model = Songs::model()->findByPk($song);
            $return_arr = array();
            if (!empty($song_model)) {
                if ($song_model->acl == 0) {
                    $song_model->acl = 1;
                    $return_arr['status'] = 'success';
                    $return_arr['label'] = 'Private';
                } else {
                    $song_model->acl = 0;
                    $return_arr['status'] = 'success';
                    $return_arr['label'] = 'Public';
                }
                $song_model->save();
            } else {
                $return_arr['status'] = 'failure';
            }
        } else {
            $return_arr['status'] = 'failure';
        }
        echo json_encode($return_arr);
    }

    public function actionAjaxTrending() {
        $user = $_POST['user'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $trending_song = Downloads::model()->trendingSong($user);
            $this->renderPartial('ajax_song', array('song_list' => $trending_song));
        } else if ($song_type == 'video') {
            $trending_video = Downloads::model()->trendingVideo($user);
            $this->renderPartial('ajax_song', array('song_list' => $trending_video));
        }
    }

    public function actionAjaxJustAdded() {
        $user = $_POST['user'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $song = Users::model()->AjaxJustAdded($user, 1);
            $this->renderPartial('ajax_song', array('song_list' => $song));
        } else if ($song_type == 'video') {
            $video = Users::model()->AjaxJustAdded($user, 2);
            $this->renderPartial('ajax_song', array('song_list' => $video));
        }
    }

    public function actionAjaxPlaylist() {
        $user = $_POST['user'];
        $playlists = Playlists::model()->findAll(array("condition" => "status = '1'  AND deleted = 0 AND user_id = '$user'    ", "order" => "date_entered desc", "limit" => 20));
        $this->renderPartial('ajax_playlist', array('playlists' => $playlists));
    }

    public function actionAjaxMyDrive() {
        $user = $_POST['user'];
        $song_type = $_POST['song_type'];


        if ($song_type == 'audio') {
            $type = 1;
        } else if ($song_type == 'video') {
            $type = 2;
        }


        $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$user' "));

        if (!empty($shared_songs)) {
            $shared_songs_ids = array();
            foreach ($shared_songs as $s) {
                array_push($shared_songs_ids, "'$s->song_id'");
            }
            $ids = implode(',', $shared_songs_ids);
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " ((created_by = '$user') OR (id IN($ids)) )  ", "order" => "date_entered desc", "limit" => 20)
            );
        } else {
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " created_by = '$user' ", "order" => "date_entered desc", "limit" => 20)
            );
        }

        $this->renderPartial('ajax_song', array('song_list' => $song_list));
    }

    public function actionAjaxPlaylistSongs() {
        $playlist = $_POST['playlist'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $type = 1;
        } else if ($song_type == 'video') {
            $type = 2;
        }
        $playlist_detail = Playlists::model()->findByPk($playlist);
        $playlist_songs = PlaylistSongs::model()->findAll(array("condition" => "playlist_id = '$playlist' AND type='$type' "));
        $this->renderPartial('ajax_playlist_songs', array('playlist_songs' => $playlist_songs, 'playlist' => $playlist, 'playlist_name' => $playlist_detail->name));
    }

    public function actionSongType() {
        $user_id = $_POST['user'];
        $song_type = $_POST['song_type'];
        if ($song_type == 'audio') {
            $type = 1;
        } else if ($song_type == 'video') {
            $type = 2;
        }

        $shared_songs = SongShare::model()->findAll(array("select" => "song_id", "condition" => "user_id = '$user_id' "));

        if (!empty($shared_songs)) {
            $shared_songs_ids = array();
            foreach ($shared_songs as $s) {
                array_push($shared_songs_ids, "'$s->song_id'");
            }
            $ids = implode(',', $shared_songs_ids);
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " ((created_by = '$user_id') OR (id IN($ids)) )  ", "order" => "date_entered desc", "limit" => 20)
            );
        } else {
            $song_list = Songs::model()->findAll(
                    array(
                        "condition" =>
                        "status = '1' AND type='$type' AND deleted = 0 AND"
                        . " created_by = '$user_id' ", "order" => "date_entered desc", "limit" => 20)
            );
        }


        $this->renderPartial('ajax_song', array('song_list' => $song_list));
    }
    
     public function actionFollowUnfollow() {
        if (Yii::app()->user->id) {
            $return_arr = array();
            $user_id = $_POST['dj_id'];
            $follower_id = $_POST['user_id'];
            $follow_unfollow = Followers::model()->find(array("condition" => " user_id = '$user_id' AND follower_id = '$follower_id' "));
            if (empty($follow_unfollow)) {
                $follower_model = new Followers;
                $follower_model->user_id = $user_id;
                $follower_model->follower_id = $follower_id;
                $follower_model->created_by = $follower_id;
                $follower_model->save();
                $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                $dj_followers_count = count($user->followers_list);
                $return_arr['followers_count'] = $dj_followers_count;
                $return_arr['follow_unfollow_text'] = "Unfollow";
                echo json_encode($return_arr);
            } else {
                if ($follow_unfollow->deleted == 0) {
                    $follow_unfollow->deleted = 1;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                    $return_arr['followers_count'] = $dj_followers_count;
                    $return_arr['follow_unfollow_text'] = "Follow";
                    echo json_encode($return_arr);
                } else if ($follow_unfollow->deleted == 1) {
                    $follow_unfollow->deleted = 0;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                    $return_arr['followers_count'] = $dj_followers_count;
                    $return_arr['follow_unfollow_text'] = "Unfollow";
                    echo json_encode($return_arr);
                }
            }
        }
    }
    
     public function actionFollowUnfollowRecommend() {
        if (Yii::app()->user->id) {
            $return_arr = array();
            $user_id = $_POST['dj_id'];
            $follower_id = $_POST['user_id'];
            $follow_unfollow = Followers::model()->find(array("condition" => " user_id = '$user_id' AND follower_id = '$follower_id' "));
            if (empty($follow_unfollow)) {
                $follower_model = new Followers;
                $follower_model->user_id = $user_id;
                $follower_model->follower_id = $follower_id;
                $follower_model->created_by = $follower_id;
                $follower_model->save();
                $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                $dj_followers_count = count($user->followers_list);
            } else {
                if ($follow_unfollow->deleted == 0) {
                    $follow_unfollow->deleted = 1;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                } else if ($follow_unfollow->deleted == 1) {
                    $follow_unfollow->deleted = 0;
                    $follow_unfollow->save();
                    $user = Users::model()->find(array("condition" => "id = '$user_id'"));
                    $dj_followers_count = count($user->followers_list);
                }
            }
            $logged_in_user_id = Yii::app()->user->id;
            $recommended_list = Users::model()->getRecommendList($logged_in_user_id, "limited");
            $this->renderPartial('ajax_recommended', array('recommended_list' => $recommended_list));
        }
    }
    
    
    

}
