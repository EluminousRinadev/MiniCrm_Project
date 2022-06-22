<?php 

Route::get('/',[App\Http\Controllers\Front\HomeController::class,'index']);

Route::get('/companyDetails/{id}',[App\Http\Controllers\Front\HomeController::class,'companyDetails']);



?>