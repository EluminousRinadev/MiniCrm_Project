<?php
	
	
	Route::post('/loginProcess', [App\Http\Controllers\Admin\AuthController::class, 'login_process']);

	$admin_path =config('app.project.admin_panel_slug');
	

	Route::group(['prefix' => $admin_path,'middleware'=>['is_admin']], function () {
		
        /*----------------------------------------------------------------------------------------
			Employee
		----------------------------------------------------------------------------------------*/

		Route::group(array('prefix'=>'/employee'), function ()
		{
		
            Route::get('/',[App\Http\Controllers\Admin\EmployeeController::class, 'index'])->name('admin.employee');
			Route::get('/EmployeeCreate',[App\Http\Controllers\Admin\EmployeeController::class, 'create'])->name('employee_create');
			Route::post('/store',[App\Http\Controllers\Admin\EmployeeController::class, 'store'])->name('employee.store');
			Route::get('/delete/{id}',[App\Http\Controllers\Admin\EmployeeController::class, 'delete'])->name('employee.delete');
			Route::any('/edit/{id}',[App\Http\Controllers\Admin\EmployeeController::class, 'edit'])->name('employee.edit');
			Route::any('/update',[App\Http\Controllers\Admin\EmployeeController::class, 'update'])->name('employee.update');
		
			
		});

		/*----------------------------------------------------------------------------------------
			Comppany
		----------------------------------------------------------------------------------------*/

		Route::group(array('prefix'=>'/company'), function ()
		{
		
            Route::get('/',[App\Http\Controllers\Admin\CompanyController::class, 'index'])->name('admin.company');
			Route::get('/CompanyCreate',[App\Http\Controllers\Admin\CompanyController::class, 'create'])->name('company_create');
			Route::post('/store',[App\Http\Controllers\Admin\CompanyController::class, 'store'])->name('company.store');
			Route::get('/delete/{id}',[App\Http\Controllers\Admin\CompanyController::class, 'delete'])->name('company.delete');
			Route::any('/edit/{id}',[App\Http\Controllers\Admin\CompanyController::class, 'edit'])->name('company.edit');
			Route::any('/update',[App\Http\Controllers\Admin\CompanyController::class, 'update'])->name('company.update');
		
			
		});


});




	






