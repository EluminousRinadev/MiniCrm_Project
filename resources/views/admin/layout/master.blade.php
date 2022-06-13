<!-- HEader -->        
@include('admin.layout._header')    
        
<!-- BEGIN left_Sidebar -->
@include('admin.layout._left_sidebar')
<!-- END left_Sidebar -->

<!-- BEGIN Content -->
<div id="main">
	
 	@yield('main_content')

 	

</div>
<!-- END Main Content -->

<!-- Footer -->        
@include('admin.layout._footer')    
                
              