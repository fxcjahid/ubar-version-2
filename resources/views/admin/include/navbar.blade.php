<!-- topbar -->
<div class="topbar" >
    <nav class="navbar navbar-expand-lg navbar-light">
       <div class="full" style="background-color: #010F58">
          <button type="button" style="background-color: #010F58" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
          <div class="logo_section">
          </div>
          <div class="right_topbar" >
             <div class="icon_info">
                <ul class="user_profile_dd" >
                   <li style="background-color: #010F58">
                      <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="{{Auth::user()->profile_pic ? url(Auth::user()->profile_pic) : asset('assets/images/layout_img/user_img.jpg')}}" alt="#" /><span class="name_user">{{Auth::user()->name}}</span></a>
                      <div class="dropdown-menu">
                         <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                         <a class="dropdown-item" href="{{ route('admin.logout') }}"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                      </div>
                   </li>
                </ul>
             </div>
          </div>
       </div>
    </nav>
 </div>
