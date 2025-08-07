<style>
    /* Sidebar Active States */
    #sidebar-menu .mm-active>a {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
    }

    #sidebar-menu .mm-active>a.active,
    #sidebar-menu a.active {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.15) !important;
        font-weight: 600;
    }

    #sidebar-menu ul.nav-second-level {
        display: none;
        /* background-color: rgba(0, 0, 0, 0.05); */
    }

    #sidebar-menu ul.nav-second-level.mm-show {
        display: block !important;
    }

    #sidebar-menu ul.nav-second-level li.mm-active>a,
    #sidebar-menu ul.nav-second-level li>a.active {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.15) !important;
        font-weight: 600;
    }

    #sidebar-menu ul.nav-second-level li.mm-active>a.active {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.25) !important;
        font-weight: 700;
    }

    /* Menu arrow rotation */
    #sidebar-menu .mm-active>a .menu-arrow {
        transform: rotate(90deg);
        transition: transform 0.2s ease;
    }

    #sidebar-menu a .menu-arrow {
        transition: transform 0.2s ease;
    }

    /* Nested submenu styling */
    #sidebar-menu ul.nav-second-level ul.nav-second-level {
        margin-left: 20px;
        border-left: 1px solid rgba(0, 0, 0, 0.1);
        /* background-color: rgba(0, 0, 0, 0.08); */
    }

    #sidebar-menu ul.nav-second-level ul.nav-second-level li a {
        padding-left: 30px;
        font-size: 13px;
    }

    #sidebar-menu ul.nav-second-level ul.nav-second-level li.mm-active>a,
    #sidebar-menu ul.nav-second-level ul.nav-second-level li>a.active {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.2) !important;
        font-weight: 600;
    }

    /* Third level nesting */
    #sidebar-menu ul.nav-second-level ul.nav-second-level ul.nav-second-level {
        margin-left: 15px;
        background-color: rgba(0, 0, 0, 0.1);
    }

    #sidebar-menu ul.nav-second-level ul.nav-second-level ul.nav-second-level li a {
        padding-left: 40px;
        font-size: 12px;
    }

    /* Hover effects */
    #sidebar-menu a:hover:not(.active) {
        background-color: rgba(0, 123, 255, 0.05) !important;
        color: #007bff !important;
    }

    #sidebar-menu ul.nav-second-level a:hover:not(.active) {
        background-color: rgba(0, 123, 255, 0.1) !important;
    }

    #sidebar-menu ul.nav-second-level ul.nav-second-level a:hover:not(.active) {
        background-color: rgba(0, 123, 255, 0.15) !important;
    }

    /* Ensure active items maintain their styling on hover */
    #sidebar-menu a.active:hover,
    #sidebar-menu .mm-active>a.active:hover {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.2) !important;
    }

    /* Parent menu item styling when it has active children */
    #sidebar-menu li.mm-active>a:not(.active) {
        color: #495057 !important;
        background-color: rgba(0, 123, 255, 0.05) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #sidebar-menu ul.nav-second-level {
            margin-left: 0;
        }

        #sidebar-menu ul.nav-second-level li a {
            padding-left: 20px;
        }

        #sidebar-menu ul.nav-second-level ul.nav-second-level li a {
            padding-left: 25px;
        }

        #sidebar-menu ul.nav-second-level ul.nav-second-level ul.nav-second-level li a {
            padding-left: 30px;
        }
    }

    /* Animation for submenu transitions */
    #sidebar-menu ul.nav-second-level {
        transition: all 0.2s ease-in-out;
    }

    /* Fix for menu items that should not have hover effects when active */
    #sidebar-menu li.mm-active>a.mm-active {
        color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
    }

    /* Visual indicators for nested menus */
    #sidebar-menu ul.nav-second-level>li>a .menu-arrow {
        font-size: 12px;
        opacity: 0.7;
    }

    #sidebar-menu ul.nav-second-level ul.nav-second-level>li>a .menu-arrow {
        font-size: 10px;
        opacity: 0.6;
    }
</style>

<div class="left side-menu" datasidebar-bg="theme05">
    <div class="">
        <div class="border-bottom d-flex align-items-center"
            style="height: 70px; background: <?php echo e(Session::get('theme_color')); ?>;">
            <div class="logo-box p-10 text-center">
                <a href="<?php echo e(url('/admin/dashboard')); ?>" title="" class="logo-dark h-100">
                    <img class="img-fluid h-100" src="<?php echo e(getDistrictLogo()); ?>" title="" alt="">
                </a>
                <a href="<?php echo e(url('/admin/dashboard')); ?>" title="" class="logo-dark-small h-100">
                    <img class="img-fluid h-100" src="<?php echo e(getDistrictLogo()); ?>" title="" alt="">
                </a>
                <a href="<?php echo e(url('/admin/dashboard')); ?>" title="" class="logo-light h-100">
                    <img class="img-fluid h-100" src="<?php echo e(getDistrictLogo()); ?>" title="" alt="">
                </a>
                <a href="<?php echo e(url('/admin/dashboard')); ?>" title="" class="logo-light-small h-100">
                    <img class="img-fluid h-100" src="<?php echo e(getDistrictLogo()); ?>" title="" alt="">
                </a>
            </div>
            <div class="side-menu-btn text-primary">
                <i class="fa-2x fas fa-bars"></i>
            </div>
        </div>
    </div>

    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul id="side-menu">
                <!-- Dashboard -->
                <li class="<?php echo e(Request::is('admin/dashboard') ? 'mm-active' : ''); ?>">
                    <a title="Dashboard" href="<?php echo e(url('/admin/dashboard')); ?>"
                        class="<?php echo e(Request::is('admin/dashboard') ? 'active' : ''); ?>">
                        <i class="far fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Submission Workspace -->
                <?php if(checkPermission(Auth::user()->role_id, 'Submissions') == 1): ?>
                    <li
                        class="<?php echo e(Request::is('admin/Submissions*') || Request::is('admin/CustomCommunication*') || Request::is('admin/GenerateApplicationData*') || Request::is('admin/Reports/admin_review*') || Request::is('admin/Reports/missing/15/gradecdiupload*') || Request::is('admin/Reports/export/submissions*') ? 'mm-active' : ''); ?>">
                        <a title="Submission Workspace" href="javascript:void(0);"
                            class="<?php echo e(Request::is('admin/Submissions*') || Request::is('admin/CustomCommunication*') || Request::is('admin/GenerateApplicationData*') || Request::is('admin/Reports/admin_review*') || Request::is('admin/Reports/missing/15/gradecdiupload*') || Request::is('admin/Reports/export/submissions*') ? 'mm-active' : ''); ?>">
                            <i class="far fa-address-card"></i>
                            <span>Submission Workspace</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level <?php echo e(Request::is('admin/Submissions*') || Request::is('admin/CustomCommunication*') || Request::is('admin/GenerateApplicationData*') || Request::is('admin/Reports/admin_review*') || Request::is('admin/Reports/missing/15/gradecdiupload*') || Request::is('admin/Reports/export/submissions*') ? 'mm-show' : ''); ?>"
                            aria-expanded="false">
                            <li
                                class="<?php echo e(Request::is('admin/Submissions') && !Request::is('admin/Submissions/*') ? 'mm-active' : ''); ?>">
                                <a title="Submissions" href="<?php echo e(url('/admin/Submissions')); ?>"
                                    class="<?php echo e(Request::is('admin/Submissions') && !Request::is('admin/Submissions/*') ? 'active' : ''); ?>">
                                    <span>Submissions</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/CustomCommunication*') ? 'mm-active' : ''); ?>">
                                <a title="Custom Communication" href="<?php echo e(url('/admin/CustomCommunication')); ?>"
                                    class="<?php echo e(Request::is('admin/CustomCommunication*') ? 'active' : ''); ?>">
                                    <span>Custom Communications</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/GenerateApplicationData') && !Request::is('admin/GenerateApplicationData/*') ? 'mm-active' : ''); ?>">
                                <a title="Generate Application Data" href="<?php echo e(url('/admin/GenerateApplicationData')); ?>"
                                    class="<?php echo e(Request::is('admin/GenerateApplicationData') && !Request::is('admin/GenerateApplicationData/*') ? 'active' : ''); ?>">
                                    <span>Generate Application Data Sheets</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/GenerateApplicationData/generated/form*') ? 'mm-active' : ''); ?>">
                                <a title="Print Writing Prompts/Recommendation"
                                    href="<?php echo e(url('/admin/GenerateApplicationData/generated/form')); ?>"
                                    class="<?php echo e(Request::is('admin/GenerateApplicationData/generated/form*') ? 'active' : ''); ?>">
                                    <span>Generate Submission Forms</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Reports/admin_review*') ? 'mm-active' : ''); ?>">
                                <a title="Admin Review" href="<?php echo e(url('/admin/Reports/admin_review')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports/admin_review*') ? 'active' : ''); ?>">
                                    <span>Admin Review</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/Reports/missing/15/gradecdiupload*') ? 'mm-active' : ''); ?>">
                                <a title="Parent Submitted Records"
                                    href="<?php echo e(url('/admin/Reports/missing/15/gradecdiupload')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports/missing/15/gradecdiupload*') ? 'active' : ''); ?>">
                                    <span>Parent Submitted Records</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Reports/export/submissions*') ? 'mm-active' : ''); ?>">
                                <a title="Export Submissions" href="<?php echo e(url('/admin/Reports/export/submissions')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports/export/submissions*') ? 'active' : ''); ?>">
                                    <span>Export Submissions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- New Enrollment Period -->
                <?php if(checkPermission(Auth::user()->role_id, 'Enrollment') == 1): ?>
                    <li class="<?php echo e(Request::is('admin/Enrollment*') ? 'mm-active' : ''); ?>">
                        <a title="Create New Enrollment Period" href="<?php echo e(url('/admin/Enrollment')); ?>"
                            class="<?php echo e(Request::is('admin/Enrollment*') ? 'active' : ''); ?>">
                            <i class="far fa-calendar-alt"></i>
                            <span>New Enrollment Period</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Setup Application -->
                <?php if(checkPermission(Auth::user()->role_id, 'Application') == 1): ?>
                    <li class="<?php echo e(Request::is('admin/Application*') ? 'mm-active' : ''); ?>">
                        <a title="Setup Application" href="<?php echo e(url('/admin/Application')); ?>"
                            class="<?php echo e(Request::is('admin/Application*') ? 'active' : ''); ?>">
                            <i class="far fa-file-alt"></i>
                            <span>Setup Application</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Set Eligibility Values -->
                <?php if(checkPermission(Auth::user()->role_id, 'SetEligibility') == 1): ?>
                    <li class="<?php echo e(Request::is('admin/SetEligibility*') ? 'mm-active' : ''); ?>">
                        <a title="Set Eligibility Values" href="<?php echo e(url('/admin/SetEligibility')); ?>"
                            class="<?php echo e(Request::is('admin/SetEligibility*') ? 'active' : ''); ?>">
                            <i class="fa fa-tasks"></i>
                            <span>Set Eligibility Values</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Process Selection -->
                <?php if(checkPermission(Auth::user()->role_id, 'Availability') == 1): ?>
                    <li
                        class="<?php echo e(Request::is('admin/Availability*') || Request::is('admin/Process/Selection*') || Request::is('admin/Preliminary/Processing*') || Request::is('admin/EditCommunication*') || Request::is('admin/DistrictConfiguration/edit_text*') || Request::is('admin/DistrictConfiguration/edit_email*') ? 'mm-active' : ''); ?>">
                        <a title="Process Selection" href="javascript:void(0);"
                            class="<?php echo e(Request::is('admin/Availability*') || Request::is('admin/Process/Selection*') || Request::is('admin/Preliminary/Processing*') || Request::is('admin/EditCommunication*') || Request::is('admin/DistrictConfiguration/edit_text*') || Request::is('admin/DistrictConfiguration/edit_email*') ? 'mm-active' : ''); ?>">
                            <i class="fa fa-user-check"></i>
                            <span>Process Selection</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level <?php echo e(Request::is('admin/Availability*') || Request::is('admin/Process/Selection*') || Request::is('admin/Preliminary/Processing*') || Request::is('admin/EditCommunication*') || Request::is('admin/DistrictConfiguration/edit_text*') || Request::is('admin/DistrictConfiguration/edit_email*') ? 'mm-show' : ''); ?>"
                            aria-expanded="false">
                            <li class="<?php echo e(Request::is('admin/Availability*') ? 'mm-active' : ''); ?>">
                                <a title="Set Availability" href="<?php echo e(url('/admin/Availability')); ?>"
                                    class="<?php echo e(Request::is('admin/Availability*') ? 'active' : ''); ?>">
                                    <span>Set Availability</span>
                                </a>
                            </li>
                            <li
                                class="d-none <?php echo e(Request::is('admin/Process/Selection/settings*') ? 'mm-active' : ''); ?>">
                                <a title="Program Max Percent Swing"
                                    href="<?php echo e(url('/admin/Process/Selection/settings')); ?>"
                                    class="<?php echo e(Request::is('admin/Process/Selection/settings*') ? 'active' : ''); ?>">
                                    <span>Program Max Percent Swing</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Preliminary/Processing*') ? 'mm-active' : ''); ?>">
                                <a title="Preliminary Processing" href="<?php echo e(url('/admin/Preliminary/Processing')); ?>"
                                    class="<?php echo e(Request::is('admin/Preliminary/Processing*') ? 'active' : ''); ?>">
                                    <span>Preliminary Processing</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/Process/Selection') && !Request::is('admin/Process/Selection/*') ? 'mm-active' : ''); ?>">
                                <a title="Process Selection" href="<?php echo e(url('/admin/Process/Selection/')); ?>"
                                    class="<?php echo e(Request::is('admin/Process/Selection') && !Request::is('admin/Process/Selection/*') ? 'active' : ''); ?>">
                                    <span>Run Selection</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/EditCommunication*') && !Request::is('admin/Waitlist/EditCommunication*') && !Request::is('admin/LateSubmission/EditCommunication*') ? 'mm-active' : ''); ?>">
                                <a title="Edit Communication" href="<?php echo e(url('/admin/EditCommunication')); ?>"
                                    class="<?php echo e(Request::is('admin/EditCommunication*') && !Request::is('admin/Waitlist/EditCommunication*') && !Request::is('admin/LateSubmission/EditCommunication*') ? 'active' : ''); ?>">
                                    <span>Edit Communication</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_text*') ? 'mm-active' : ''); ?>">
                                <a title="Edit Screen Text"
                                    href="<?php echo e(url('/admin/DistrictConfiguration/edit_text')); ?>"
                                    class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_text*') ? 'active' : ''); ?>">
                                    <span>Edit Screen Text</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_email*') ? 'mm-active' : ''); ?>">
                                <a title="Edit Final Confirmation Email"
                                    href="<?php echo e(url('/admin/DistrictConfiguration/edit_email')); ?>"
                                    class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_email*') ? 'active' : ''); ?>">
                                    <span>Edit Final Confirmation Email</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Process Waitlist -->
                <li
                    class="<?php echo e(Request::is('admin/Waitlist*') || Request::is('admin/DistrictConfiguration/edit_waitlist_text*') || Request::is('admin/DistrictConfiguration/edit_waitlist_email*') ? 'mm-active' : ''); ?>">
                    <a title="Process Waitlist" href="javascript:void(0);"
                        class="<?php echo e(Request::is('admin/Waitlist*') || Request::is('admin/DistrictConfiguration/edit_waitlist_text*') || Request::is('admin/DistrictConfiguration/edit_waitlist_email*') ? 'mm-active' : ''); ?>">
                        <i class="fa fa-user-cog"></i>
                        <span>Process Waitlist</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level <?php echo e(Request::is('admin/Waitlist*') || Request::is('admin/DistrictConfiguration/edit_waitlist_text*') || Request::is('admin/DistrictConfiguration/edit_waitlist_email*') ? 'mm-show' : ''); ?>"
                        aria-expanded="false">
                        <li
                            class="<?php echo e(Request::is('admin/Waitlist') && !Request::is('admin/Waitlist/*') ? 'mm-active' : ''); ?>">
                            <a title="Run Selection" href="<?php echo e(url('/admin/Waitlist')); ?>"
                                class="<?php echo e(Request::is('admin/Waitlist') && !Request::is('admin/Waitlist/*') ? 'active' : ''); ?>">
                                <span>Run Selection</span>
                            </a>
                        </li>
                        <li class="<?php echo e(Request::is('admin/Waitlist/EditCommunication*') ? 'mm-active' : ''); ?>">
                            <a title="Edit Communication" href="<?php echo e(url('/admin/Waitlist/EditCommunication')); ?>"
                                class="<?php echo e(Request::is('admin/Waitlist/EditCommunication*') ? 'active' : ''); ?>">
                                <span>Edit Communication</span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_waitlist_text*') ? 'mm-active' : ''); ?>">
                            <a title="Edit Screen Text"
                                href="<?php echo e(url('/admin/DistrictConfiguration/edit_waitlist_text')); ?>"
                                class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_waitlist_text*') ? 'active' : ''); ?>">
                                <span>Edit Screen Text</span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_waitlist_email*') ? 'mm-active' : ''); ?>">
                            <a title="Edit Final Confirmation Email"
                                href="<?php echo e(url('/admin/DistrictConfiguration/edit_waitlist_email')); ?>"
                                class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_waitlist_email*') ? 'active' : ''); ?>">
                                <span>Edit Final Confirmation Email</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Process Late Submission -->
                <li
                    class="<?php echo e(Request::is('admin/LateSubmission*') || Request::is('admin/DistrictConfiguration/edit_late_submission_text*') || Request::is('admin/DistrictConfiguration/edit_late_submission_email*') ? 'mm-active' : ''); ?>">
                    <a title="Process Late Submission" href="javascript:void(0);"
                        class="<?php echo e(Request::is('admin/LateSubmission*') || Request::is('admin/DistrictConfiguration/edit_late_submission_text*') || Request::is('admin/DistrictConfiguration/edit_late_submission_email*') ? 'mm-active' : ''); ?>">
                        <i class="fa fa-user-clock"></i>
                        <span>Process Late Submission</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level <?php echo e(Request::is('admin/LateSubmission*') || Request::is('admin/DistrictConfiguration/edit_late_submission_text*') || Request::is('admin/DistrictConfiguration/edit_late_submission_email*') ? 'mm-show' : ''); ?>"
                        aria-expanded="false">
                        <li
                            class="<?php echo e(Request::is('admin/LateSubmission/Preliminary/Processing*') ? 'mm-active' : ''); ?>">
                            <a title="Preliminary Processing"
                                href="<?php echo e(url('/admin/LateSubmission/Preliminary/Processing')); ?>"
                                class="<?php echo e(Request::is('admin/LateSubmission/Preliminary/Processing*') ? 'active' : ''); ?>">
                                <span>Preliminary Processing</span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(Request::is('admin/LateSubmission') && !Request::is('admin/LateSubmission/*') ? 'mm-active' : ''); ?>">
                            <a title="Run Selection" href="<?php echo e(url('/admin/LateSubmission')); ?>"
                                class="<?php echo e(Request::is('admin/LateSubmission') && !Request::is('admin/LateSubmission/*') ? 'active' : ''); ?>">
                                <span>Run Selection</span>
                            </a>
                        </li>
                        <li class="<?php echo e(Request::is('admin/LateSubmission/EditCommunication*') ? 'mm-active' : ''); ?>">
                            <a title="Edit Communication" href="<?php echo e(url('/admin/LateSubmission/EditCommunication')); ?>"
                                class="<?php echo e(Request::is('admin/LateSubmission/EditCommunication*') ? 'active' : ''); ?>">
                                <span>Edit Communication</span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_late_submission_text*') ? 'mm-active' : ''); ?>">
                            <a title="Edit Screen Text"
                                href="<?php echo e(url('/admin/DistrictConfiguration/edit_late_submission_text')); ?>"
                                class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_late_submission_text*') ? 'active' : ''); ?>">
                                <span>Edit Screen Text</span>
                            </a>
                        </li>
                        <li
                            class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_late_submission_email*') ? 'mm-active' : ''); ?>">
                            <a title="Edit Final Confirmation Email"
                                href="<?php echo e(url('/admin/DistrictConfiguration/edit_late_submission_email')); ?>"
                                class="<?php echo e(Request::is('admin/DistrictConfiguration/edit_late_submission_email*') ? 'active' : ''); ?>">
                                <span>Edit Final Confirmation Email</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--<li class=""><a title="Front End" href="form.html"><i class="far fa-list-alt"></i><span>Forms</span></a></li>
                <li class=""><a title="Program" href="program.html"><i class="far fa-star"></i><span>Programs</span></a></li>
                <li class=""><a title="School" href="school.html"><i class="fas fa-school"></i><span>Schools</span></a></li>
                <li class=""><a title="Files" href="files.html"><i class="far fa-folder-open"></i><span>Files</span></a></li>
                            
                <li class=""><a title="Translation" href="translation.html"><i class="fas fa-language"></i><span>Translations</span></a></li>
                <li class=""><a title="Emails / Letters" href="javascript:void(0);"><i class="far fa-envelope"></i><span>Emails / Letters</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a title="Applications" href="application-emails-letters.html"><span>Applications</span></a></li>
                        <li><a title="Program Processing" href="program-processing-emails-letters.html"><span>Program Processing</span></a></li>
                    </ul>
                </li>
               
                <li class=""><a title="Date" href="javascript:void(0);"><i class="far fa-calendar-alt"></i><span>Dates</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a title="Application Dates" href="application-dates.html"><span>Application Dates</span></a></li>
                        <li><a title="Program Processing Dates" href="program-processing-dates.html"><span>Program Processing Dates</span></a></li>
                    </ul>
                </li>
                <li class=""><a title="Override" href="override.html"><i class="far fa-check-circle"></i><span>Overrides</span></a></li>
                <li class=""><a title="Report" href="report.html"><i class="fas fa-chart-pie"></i><span>Reports</span></a></li>
                -->

                <!--<li class=""><a title="Configuration" href="javascript:void(0);"><i class="fas fa-cog"></i><span>Configurations</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a title="Header & Footer" href="header-footer-configuration.html"><span>Header &amp; Footer</span></a></li>
                        <li><a title="Eligibility" href="eligibility.html"><span>Eligibility</span></a></li>
                        <li><a title="Program Processing" href="program-processing-configuration.html"><span>Program Processing</span></a></li>
                    </ul>
                </li>-->
                <!-- Reports -->
                <?php if(checkPermission(Auth::user()->role_id, 'Reports/missing/grade') == 1 ||
                        checkPermission(Auth::user()->role_id, 'Reports/missing/cdi') == 1): ?>
                    <li class="<?php echo e(Request::is('admin/Reports/missing*') ? 'mm-active' : ''); ?>">
                        <a title="Reports" href="<?php echo e(url('/admin/Reports/missing')); ?>"
                            class="<?php echo e(Request::is('admin/Reports/missing*') ? 'active' : ''); ?>">
                            <i class="far fa-file-alt"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Administration -->
                <?php if(checkPermission(Auth::user()->role_id, 'Configuration') == 1 || Auth::user()->role_id == 2): ?>
                    <li
                        class="<?php echo e(Request::is('admin/Reports/process/logs*') || Request::is('admin/Reports/process/real/logs*') || Request::is('admin/Files*') || Request::is('admin/Configuration*') || Request::is('admin/AuditTrailData*') || Request::is('admin/DistrictConfiguration') || Request::is('admin/Users*') || Request::is('admin/GiftedStudents*') || Request::is('admin/import/agt_nch*') || Request::is('admin/StudentSearch*') || Request::is('admin/Process/Selection/program/availability*') || Request::is('admin/Process/Selection/waitlist/export*') ? 'mm-active' : ''); ?>">
                        <a title="Administration" href="javascript:void(0);"
                            class="<?php echo e(Request::is('admin/Reports/process/logs*') || Request::is('admin/Reports/process/real/logs*') || Request::is('admin/Files*') || Request::is('admin/Configuration*') || Request::is('admin/AuditTrailData*') || Request::is('admin/DistrictConfiguration') || Request::is('admin/Users*') || Request::is('admin/GiftedStudents*') || Request::is('admin/import/agt_nch*') || Request::is('admin/StudentSearch*') || Request::is('admin/Process/Selection/program/availability*') || Request::is('admin/Process/Selection/waitlist/export*') ? 'mm-active' : ''); ?>">
                            <i class="fas fa-cog"></i>
                            <span>Administration</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level <?php echo e(Request::is('admin/Reports/process/logs*') || Request::is('admin/Reports/process/real/logs*') || Request::is('admin/Files*') || Request::is('admin/Configuration*') || Request::is('admin/AuditTrailData*') || Request::is('admin/DistrictConfiguration') || Request::is('admin/Users*') || Request::is('admin/GiftedStudents*') || Request::is('admin/import/agt_nch*') || Request::is('admin/StudentSearch*') || Request::is('admin/Process/Selection/program/availability*') || Request::is('admin/Process/Selection/waitlist/export*') ? 'mm-show' : ''); ?>"
                            aria-expanded="false">
                            <li class="<?php echo e(Request::is('admin/Reports/process/logs*') ? 'mm-active' : ''); ?>">
                                <a title="Process Log Report" href="<?php echo e(url('/admin/Reports/process/logs')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports/process/logs*') ? 'active' : ''); ?>">
                                    <span>Process Log Report</span>
                                </a>
                            </li>
                            <li
                                class="d-none <?php echo e(Request::is('admin/Reports/process/real/logs*') ? 'mm-active' : ''); ?>">
                                <a title="Real Process Log Report"
                                    href="<?php echo e(url('/admin/Reports/process/real/logs')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports/process/real/logs*') ? 'active' : ''); ?>">
                                    <span>Seats Status Report</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Files*') ? 'mm-active' : ''); ?>">
                                <a title="Front Page Links" href="<?php echo e(url('/admin/Files')); ?>"
                                    class="<?php echo e(Request::is('admin/Files*') ? 'active' : ''); ?>">
                                    <span>Front Page Links</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Configuration*') ? 'mm-active' : ''); ?>">
                                <a title="Welcome Texts" href="<?php echo e(url('/admin/Configuration')); ?>"
                                    class="<?php echo e(Request::is('admin/Configuration*') ? 'active' : ''); ?>">
                                    <span>Texts</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/AuditTrailData*') ? 'mm-active' : ''); ?>">
                                <a title="Audit Trails" href="<?php echo e(url('/admin/AuditTrailData')); ?>"
                                    class="<?php echo e(Request::is('admin/AuditTrailData*') ? 'active' : ''); ?>">
                                    <span>Audit Trail</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/DistrictConfiguration') && !Request::is('admin/DistrictConfiguration/*') ? 'mm-active' : ''); ?>">
                                <a title="District Configuration" href="<?php echo e(url('/admin/DistrictConfiguration')); ?>"
                                    class="<?php echo e(Request::is('admin/DistrictConfiguration') && !Request::is('admin/DistrictConfiguration/*') ? 'active' : ''); ?>">
                                    <span>District Configuration</span>
                                </a>
                            </li>
                            <?php if(Auth::user()->role_id == 1): ?>
                                <li class="<?php echo e(Request::is('admin/Users*') ? 'mm-active' : ''); ?>">
                                    <a title="User" href="<?php echo e(url('admin/Users')); ?>"
                                        class="<?php echo e(Request::is('admin/Users*') ? 'active' : ''); ?>">
                                        <span>Users</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="<?php echo e(Request::is('admin/GiftedStudents*') ? 'mm-active' : ''); ?>">
                                <a title="Gifted Students" href="<?php echo e(url('/admin/GiftedStudents')); ?>"
                                    class="<?php echo e(Request::is('admin/GiftedStudents*') ? 'active' : ''); ?>">
                                    <span>Gifted Students</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/import/agt_nch*') ? 'mm-active' : ''); ?>">
                                <a title="Import Student Data for Program" href="<?php echo e(url('/admin/import/agt_nch')); ?>"
                                    class="<?php echo e(Request::is('admin/import/agt_nch*') ? 'active' : ''); ?>">
                                    <span>Import Student Data for Program</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/StudentSearch*') ? 'mm-active' : ''); ?>">
                                <a title="Student Data Override" href="<?php echo e(url('')); ?>/admin/StudentSearch"
                                    class="<?php echo e(Request::is('admin/StudentSearch*') ? 'active' : ''); ?>">
                                    <span>Student Data Override</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/Process/Selection/program/availability*') ? 'mm-active' : ''); ?>">
                                <a title="Program Availability Export"
                                    href="<?php echo e(url('')); ?>/admin/Process/Selection/program/availability"
                                    class="<?php echo e(Request::is('admin/Process/Selection/program/availability*') ? 'active' : ''); ?>">
                                    <span>Program Availability Export</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/Process/Selection/waitlist/export*') ? 'mm-active' : ''); ?>">
                                <a title="Waitlist Export"
                                    href="<?php echo e(url('')); ?>/admin/Process/Selection/waitlist/export"
                                    class="<?php echo e(Request::is('admin/Process/Selection/waitlist/export*') ? 'active' : ''); ?>">
                                    <span>Waitlist Export</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Master -->
                <?php if(Auth::user()->role_id == 1): ?>
                    <li
                        class="master <?php echo e(Request::is('admin/District*') || Request::is('admin/Program*') || Request::is('admin/Eligibility*') || Request::is('admin/School*') || Request::is('admin/Priority*') || Request::is('admin/Reports') || Request::is('admin/Waitlist/Admin/Selection*') || Request::is('admin/LateSubmission/Admin/Selection*') || Request::is('admin/Form*') || Request::is('admin/Reports/Waitlist*') || Request::is('admin/Role*') || Request::is('admin/ZonedSchool*') || Request::is('admin/ConfigureExportSubmission*') || Request::is('admin/EligibilityChecker*') ? 'mm-active' : ''); ?>">
                        <a title="Master" href="javascript:void(0);"
                            class="<?php echo e(Request::is('admin/District*') || Request::is('admin/Program*') || Request::is('admin/Eligibility*') || Request::is('admin/School*') || Request::is('admin/Priority*') || Request::is('admin/Reports') || Request::is('admin/Waitlist/Admin/Selection*') || Request::is('admin/LateSubmission/Admin/Selection*') || Request::is('admin/Form*') || Request::is('admin/Reports/Waitlist*') || Request::is('admin/Role*') || Request::is('admin/ZonedSchool*') || Request::is('admin/ConfigureExportSubmission*') || Request::is('admin/EligibilityChecker*') ? 'mm-active' : ''); ?>">
                            <i class="far fa-gem"></i>
                            <span>Master</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level <?php echo e(Request::is('admin/District*') || Request::is('admin/Program*') || Request::is('admin/Eligibility*') || Request::is('admin/School*') || Request::is('admin/Priority*') || Request::is('admin/Reports') || Request::is('admin/Waitlist/Admin/Selection*') || Request::is('admin/LateSubmission/Admin/Selection*') || Request::is('admin/Form*') || Request::is('admin/Reports/Waitlist*') || Request::is('admin/Role*') || Request::is('admin/ZonedSchool*') || Request::is('admin/ConfigureExportSubmission*') || Request::is('admin/EligibilityChecker*') ? 'mm-show' : ''); ?>"
                            aria-expanded="false">
                            <?php if(checkPermission(Auth::user()->role_id, 'District') == 1): ?>
                                <?php if(Session::get('super_admin') == 'Y'): ?>
                                    <li class="<?php echo e(Request::is('admin/District*') ? 'mm-active' : ''); ?>">
                                        <a title="District Master" href="<?php echo e(url('/admin/District')); ?>"
                                            class="<?php echo e(Request::is('admin/District*') ? 'active' : ''); ?>">
                                            <span>District Master</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <li class="<?php echo e(Request::is('admin/Program*') ? 'mm-active' : ''); ?>">
                                <a title="Program Master" href="<?php echo e(url('/admin/Program')); ?>"
                                    class="<?php echo e(Request::is('admin/Program*') ? 'active' : ''); ?>">
                                    <span>Program Master</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Eligibility*') ? 'mm-active' : ''); ?>">
                                <a title="Eligibility Master" href="<?php echo e(url('/admin/Eligibility')); ?>"
                                    class="<?php echo e(Request::is('admin/Eligibility*') ? 'active' : ''); ?>">
                                    <span>Eligibility Master</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/School*') ? 'mm-active' : ''); ?>">
                                <a title="School Master" href="<?php echo e(url('/admin/School')); ?>"
                                    class="<?php echo e(Request::is('admin/School*') ? 'active' : ''); ?>">
                                    <span>School Master</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Priority*') ? 'mm-active' : ''); ?>">
                                <a title="Priority Master" href="<?php echo e(url('/admin/Priority')); ?>"
                                    class="<?php echo e(Request::is('admin/Priority*') ? 'active' : ''); ?>">
                                    <span>Priority Master</span>
                                </a>
                            </li>
                            <li
                                class="<?php echo e(Request::is('admin/Reports') || Request::is('admin/Waitlist/Admin/Selection*') || Request::is('admin/LateSubmission/Admin/Selection*') ? 'mm-active' : ''); ?>">
                                <a title="Process Selection" href="<?php echo e(url('/admin/Reports')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports') && !Request::is('admin/Reports/*') ? 'active' : ''); ?>">
                                    <span>Run Admin Selection</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level <?php echo e(Request::is('admin/Reports') || Request::is('admin/Waitlist/Admin/Selection*') || Request::is('admin/LateSubmission/Admin/Selection*') ? 'mm-show' : ''); ?>"
                                    aria-expanded="false">
                                    <li
                                        class="pl-20 <?php echo e(Request::is('admin/Reports') && !Request::is('admin/Reports/*') ? 'mm-active' : ''); ?>">
                                        <a title="Regular Submissions" href="<?php echo e(url('/admin/Reports')); ?>"
                                            class="<?php echo e(Request::is('admin/Reports') && !Request::is('admin/Reports/*') ? 'active' : ''); ?>">
                                            <span>Regular</span>
                                        </a>
                                    </li>
                                    <li
                                        class="pl-20 <?php echo e(Request::is('admin/Waitlist/Admin/Selection*') ? 'mm-active' : ''); ?>">
                                        <a title="Waitlist Submissions"
                                            href="<?php echo e(url('/admin/Waitlist/Admin/Selection')); ?>"
                                            class="<?php echo e(Request::is('admin/Waitlist/Admin/Selection*') ? 'active' : ''); ?>">
                                            <span>Waitlist</span>
                                        </a>
                                    </li>
                                    <li
                                        class="pl-20 <?php echo e(Request::is('admin/LateSubmission/Admin/Selection*') ? 'mm-active' : ''); ?>">
                                        <a title="Late Submission Master"
                                            href="<?php echo e(url('/admin/LateSubmission/Admin/Selection')); ?>"
                                            class="<?php echo e(Request::is('admin/LateSubmission/Admin/Selection*') ? 'active' : ''); ?>">
                                            <span>Late Submission</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Form*') ? 'mm-active' : ''); ?>">
                                <a title="Form Master" href="<?php echo e(url('/admin/Form')); ?>"
                                    class="<?php echo e(Request::is('admin/Form*') ? 'active' : ''); ?>">
                                    <span>Submissions Form Master</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Reports/Waitlist*') ? 'mm-active' : ''); ?>">
                                <a title="Report Master" href="<?php echo e(url('/admin/Reports/Waitlist')); ?>"
                                    class="<?php echo e(Request::is('admin/Reports/Waitlist*') ? 'active' : ''); ?>">
                                    <span>Selection Report Master</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/Role*') ? 'mm-active' : ''); ?>">
                                <a title="Priority Master" href="<?php echo e(url('/admin/Role')); ?>"
                                    class="<?php echo e(Request::is('admin/Role*') ? 'active' : ''); ?>">
                                    <span>User Role Master</span>
                                </a>
                            </li>
                            <li class="d-none <?php echo e(Request::is('admin/ZonedSchool*') ? 'mm-active' : ''); ?>">
                                <a title="Zone Address" href="<?php echo e(url('/admin/ZonedSchool')); ?>"
                                    class="<?php echo e(Request::is('admin/ZonedSchool*') ? 'active' : ''); ?>">
                                    <span>Upload School Address</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/ConfigureExportSubmission*') ? 'mm-active' : ''); ?>">
                                <a title="Zone Address" href="<?php echo e(url('/admin/ConfigureExportSubmission')); ?>"
                                    class="<?php echo e(Request::is('admin/ConfigureExportSubmission*') ? 'active' : ''); ?>">
                                    <span>Export Submissions Configuration</span>
                                </a>
                            </li>
                            <li class="<?php echo e(Request::is('admin/EligibilityChecker*') ? 'mm-active' : ''); ?>">
                                <a title="Eligibility Validator" href="<?php echo e(url('/admin/EligibilityChecker')); ?>"
                                    class="<?php echo e(Request::is('admin/EligibilityChecker*') ? 'active' : ''); ?>">
                                    <span>Eligibility Validator</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\resources\views/layouts/admin/common/sidebar.blade.php ENDPATH**/ ?>