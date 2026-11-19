 <header class="header" id="header">
     <div class="container header-container">
         <!-- Logo -->
         <a href="<?= BASE_PATH ?>/" class="header-logo">
             <img src="<?= BASE_PATH ?>/assets/images/logo/mainlogo.png" alt="Cornell Institute of Training"
                 class="header-logo-img" />
         </a>

         <!-- Desktop Navigation -->
         <nav class="header-nav" id="headerNav">
             <ul class="header-menu">
                 <li><a href="<?= BASE_PATH ?>/" class="header-link active">Home</a></li>
                 <li><a href="<?= BASE_PATH ?>/courses" class="header-link">Courses</a></li>

                 <!-- Mega Menu Item -->
                 <li class="has-mega">
                     <button class="header-link mega-trigger" aria-expanded="false">
                         Student Support
                         <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5">
                             <path d="M6 9l6 6 6-6" />
                         </svg>
                     </button>

                     <!-- Mega Menu -->
                     <div class="mega-menu">
                         <div class="mega-menu-inner">
                             <div class="mega-col">
                                 <h4 class="mega-title">Student Resources</h4>
                                 <ul>
                                     <li><a href="<?= BASE_PATH ?>/student-support#resources">Student Handbook</a></li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#policies">Policies &amp;
                                             Procedures</a></li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#policies">Fees &amp; Refunds</a></li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#resources">Timetables</a></li>
                                 </ul>
                             </div>

                             <div class="mega-col">
                                 <h4 class="mega-title">Support Services</h4>
                                 <ul>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Academic
                                             Support</a></li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Wellbeing &amp;
                                             Counselling</a>
                                     </li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Disability
                                             Support</a></li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Career Guidance</a>
                                     </li>
                                 </ul>
                             </div>

                             <div class="mega-col">
                                 <h4 class="mega-title">International Students</h4>
                                 <ul>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Visa &amp; ESOS
                                             Information</a>
                                     </li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Orientation</a>
                                     </li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#support-services">Overseas Student
                                             Health
                                             Cover</a></li>
                                     <li><a href="<?= BASE_PATH ?>/student-support#contacts">Contact International
                                             Team</a></li>
                                 </ul>
                             </div>

                             <div class="mega-col mega-col-highlight">
                                 <h4 class="mega-title">Need Help?</h4>
                                 <p class="mega-text">
                                     Our student support team is here to assist you with any
                                     questions.
                                 </p>
                                 <a href="<?= BASE_PATH ?>/student-support" class="btn-pill btn-pill-primary"
                                     style="margin-top: 1rem">
                                     Contact Support
                                     <span class="btn-icon">↗</span>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </li>
                 <li>
                     <a href="<?= BASE_PATH ?>/agents" class="header-link">Agents Hub</a>
                 </li>
                 <li><a href="<?= BASE_PATH ?>/about" class="header-link">About</a></li>


             </ul>
         </nav>

         <!-- CTA Button -->
         <a href="<?= BASE_PATH ?>/contact#enquire" class="btn-pill btn-pill-accent header-cta">
             Contact Now
             <span class="btn-icon">↗</span>
         </a>

         <!-- Mobile Toggle -->
         <button class="header-toggle" id="headerToggle" aria-label="Toggle menu">
             <span></span>
             <span></span>
             <span></span>
         </button>
     </div>
 </header>