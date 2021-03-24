<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item start active open" >
                <a href="/admin/home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">الرئيسية</span>
                    <span class="selected"></span>

                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">القائمة الجانبية</h3>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admins') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">المشرفين</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="{{ url('/admin/admins') }}" class="nav-link ">
                            <span class="title">عرض المشرفين</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/admins/create') }}" class="nav-link ">
                            <span class="title">اضافة مشرف</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/users') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">المستخدمين</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="{{ url('/admin/users/stores') }}" class="nav-link ">
                            <span class="title">المتاجر  </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/add/user') }}" class="nav-link ">
                            <span class="title">العملاء</span>
                        </a>
                    </li>

                </ul>
            </li>
            {{-- <li class="nav-item {{ strpos(URL::current(), 'admin/contacts') !== false ? 'active' : '' }}">
                <a href="{{ route('Contact') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  أتصل بنا </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li> --}}
            {{-- <li class="nav-item {{ strpos(URL::current(), 'admin/edit/admin_email') !== false ? 'active' : '' }}">
                <a href="{{ route('editAdminEmail') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title"> أيميل  التطبيق </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li> --}}
            <li class="nav-item {{ strpos(URL::current(), 'admin/countries') !== false ? 'active' : '' }}">
                <a href="{{ route('countries.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  الدول  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/banks') !== false ? 'active' : '' }}">
                <a href="{{ route('banks.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  البنوك  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/categories') !== false ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  الاقسام  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admin/members') !== false ? 'active' : '' }}">
                <a href="{{ route('members.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  العضويات  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admin/sliders') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الاسلايدر</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{route('sliders.index')}}" class="nav-link ">
                            <span class="title">الداش بورد</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <span class="title"> المتاجر</span>
                        </a>
                    </li>




                </ul>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/general-notifications') !== false ? 'active' : '' }}">
                <a href="{{ route('notifications.generalPage') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  الاشعارات العامة  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>


            <li class="nav-item {{ strpos(URL::current(), 'admin/comfirm-bank-replacementpoint') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">طلبات الاستبدال</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="{{route('replacement_confirmingBank')}}" class="nav-link ">
                            <span class="title">عن طريق البنك:المؤكده  </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('replacement_unconfirmingBank')}}" class="nav-link ">
                            <span class="title">عن طريق البنك :غير مؤكده  </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notifications.userPage')}}" class="nav-link ">
                            <span class="title">عن طريق ماي فاتورة : المؤكده  </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notifications.userPage')}}" class="nav-link ">
                            <span class="title">عن طريق ماي فاتورة : غير مؤكده  </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admin/category-notifications') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">الاشعارات المخصصه</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="{{route('notifications.categoryPage')}}" class="nav-link ">
                            <span class="title">اشعارات حسب الفئة  </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('notifications.userPage')}}" class="nav-link ">
                            <span class="title">اشعارات لعملاء التطبيق  </span>
                        </a>
                    </li>


                </ul>
            </li>

            <li class="nav-item {{ strpos(URL::current(), 'admin/suggestions') !== false ? 'active' : '' }}">
                <a href="{{ route('suggestions.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  الاقتراحات  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/contacts') !== false ? 'active' : '' }}">
                <a href="{{ route('contacts.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  تواصل معنا  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            
            <li class="nav-item {{ strpos(URL::current(), 'admin/setting') !== false ? 'active' : '' }}">
                <a href="{{ route('settings.index') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  اعدادات الموقع  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/change-logo') !== false ? 'active' : '' }}">
                <a href="{{ route('change_logo') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  تغيير شعار الموقع  </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            {{-- <li class="nav-item {{ strpos(URL::current(), 'admin/payment_value') !== false ? 'active' : '' }}">
                <a href="{{ route('payment_value') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title"> قيمة الدفع </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="nav-item {{ strpos(URL::current(), 'admin/parteners') !== false ? 'active' : '' }}">
                <a href="{{ route('parteners') }}" class="nav-link ">
                    <i class="icon-layers"></i>
                    <span class="title">  الأشتراكات  المؤكدة </span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li> --}}


{{-- 
            <li class="nav-item {{ strpos(URL::current(), 'admin/pages') !== false ? 'active' : '' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الصفحات</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="/admin/pages/about" class="nav-link ">
                            <span class="title">من نحن</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="/admin/pages/terms" class="nav-link ">
                            <span class="title">الشروط والاحكام</span>
                        </a>
                    </li>




                </ul>
            </li> --}}



        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
