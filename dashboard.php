<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$noE = 0;
$noC = 0;
$noD = 0;
$users = $override->getData('user');
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('edit_file_status')) {
            if (Input::get('status') == 1) {
                $st = 0;
            } else {
                $st = 2;
            }
            try {
                $user->updateRecord('file_request', array('status' => $st, 'approved_on' => date('Y-m-d H:i:s'), 'approve_staff' => $user->data()->id), Input::get('request_id'));
                $user->updateRecord('study_files', array('status' => 1), Input::get('id'));
            } catch (Exception $e) {
                $e->getMessage();
            }
            $successMessage = 'File Status changed successful';
        }
    }
} else {
    Redirect::to('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> Dashboard - TanCov</title>
    <?php include "head.php"; ?>
</head>

<body>
    <div class="wrapper">

        <?php include 'topbar.php' ?>
        <?php include 'menu.php' ?>
        <div class="content">


            <div class="breadLine">

                <ul class="breadcrumb">
                    <li><a href="#">Dashboard</a> <span class="divider">></span></li>
                </ul>
                <?php include 'pageInfo.php' ?>
            </div>

            <div class="workplace">

                <div class="row">

                    <div class="col-md-4">

                        <div class="wBlock red clearfix">
                            <div class="dSpace">
                                <h3>Screened</h3>
                                <span class="mChartBar" sparkType="bar" sparkBarColor="white">
                                    <!--130,190,260,230,290,400,340,360,390-->
                                </span>
                                <a href="info.php?id=4">
                                    <span class="number"></span>
                                </a>
                            </div>

                            <!-- 
                    <li class="">
                        <a href="info.php?id=4">
                            <span class="glyphicon glyphicon-list"></span><span class="text">Manage Studies</span>
                        </a>
                    </li> -->

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="wBlock green clearfix">
                            <div class="dSpace">
                                <h3>Enrolled</h3>
                                <span class="mChartBar" sparkType="bar" sparkBarColor="white">
                                    <!--5,10,15,20,23,21,25,20,15,10,25,20,10-->
                                </span>
                                <a href="info.php?id=3">
                                    <span class="number"></span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="wBlock blue clearfix">
                            <div class="dSpace">
                                <h3>End of study</h3>
                                <span class="mChartBar" sparkType="bar" sparkBarColor="white">
                                    <!--240,234,150,290,310,240,210,400,320,198,250,222,111,240,221,340,250,190-->
                                </span>
                                <a href="info.php?id=6">
                                    <span class="number"></span>
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="dr"><span></span></div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($errorMessage) { ?>
                            <div class="alert alert-danger">
                                <h4>Error!</h4>
                                <?= $errorMessage ?>
                            </div>
                        <?php } elseif ($pageError) { ?>
                            <div class="alert alert-danger">
                                <h4>Error!</h4>
                                <?php foreach ($pageError as $error) {
                                    echo $error . ' , ';
                                } ?>
                            </div>
                        <?php } elseif ($successMessage) { ?>
                            <div class="alert alert-success">
                                <h4>Success!</h4>
                                <?= $successMessage ?>
                            </div>
                        <?php } ?>
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>File </h1>
                            <ul class="buttons">
                                <li><a href="view_pdf.php?pdf=1" class="isw-download"></a></li>
                                <li><a href="#" class="isw-attachment"></a></li>
                                <li>
                                    <a href="#" class="isw-settings"></a>
                                    <ul class="dd-list">
                                        <li><a href="#"><span class="isw-plus"></span> New document</a></li>
                                        <li><a href="#"><span class="isw-edit"></span> Edit</a></li>
                                        <li><a href="#"><span class="isw-delete"></span> Delete</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="block-fluid">
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th width="7%">ID</th>
                                        <th width="5%">Study</th>
                                        <th width="5%">Type</th>
                                        <th width="15%">Requested Date</th>
                                        <th width="15%">Requested Staff</th>
                                        <th width="15%">File Status</th>
                                        <th width="15%">Request Status</th>
                                        <?php if($user->data()->power == 1){?>
                                        <th width="25%">Manage</th>
                                        <?php }?>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="dr"><span></span></div>

                <div class="row">

                </div>

                <div class="dr"><span></span></div>
            </div>

        </div>
    </div>
    <script>
        <?php if ($user->data()->pswd == 0) { ?>
            $(window).on('load', function() {
                $("#change_password_n").modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');
            });
        <?php } ?>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>