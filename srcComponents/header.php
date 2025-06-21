<?php
// Determine if we're on a shortreads path
$currentUri = $_SERVER['REQUEST_URI'];
$isShortReads = stripos($currentUri, '/shortreads') === 0;
$logoFile = $isShortReads ? 'logo-shortreads.svg' : 'logo.svg';
$logoLink = $isShortReads ? '/shortreads/' : '/';
?>
<header class="main-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-8">
                <ul class="no-style margin-v-none padd-left-none">
                    <li class="action-header-list header-menu">
                        <div class="menu-button">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </li>
                    <?php if (basename($_SERVER['PHP_SELF']) !== 'index.php'): ?>
                        <li class="action-header-list home-menu hidden-xs">
                            <a data-ev-cat="nav" data-ev-act="home button" href="https://theindicvoice.com">
                                <img src="/assets/images/icons/home-icon.svg" alt="home icon" width="28" height="28">
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="action-header-list search-menu hidden-xs">
                        <img src="/assets/images/icons/search-dark.svg" alt="search icon" width="28" height="28">
                    </li>
                </ul>
                <div class="header-collapse">
                    <form role="search" method="get" class="search-inp-wrap responsive-search" action="/s">
                        <label>
                            <span class="screen-reader-text"></span>
                            <input type="search" class="form-control aa-input" placeholder="Search The Indic Voice..." value="" name="search" autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto">
                            <pre aria-hidden="true" style="position:absolute;visibility:hidden;white-space:pre;font-family:&quot;font-style:normal;font-variant:normal;font-weight:400;word-spacing:0;letter-spacing:normal;text-indent:0;text-rendering:auto;text-transform:none"></pre>
                        </label>
                        <button type="submit" class="search-submit" value="Search">
                            <img src="/assets/images/icons/search-dark.svg" class="icon-search" alt="search icon" width="28" height="28">
                        </button>
                    </form>
                    <div class="header-collapse-inner">
                        <div class="tabs-wrapper">
                            <ul class="tabs-menu nav-pills-tabs">
                                <li>
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="shortreads" class="tab-item active-tab-menu" href="#" data-tab="tab1">ShortReads</a>
                                </li>
                                <li>
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="topics" class="tab-item" href="#" data-tab="tab2">Topics</a>
                                </li>
                                <li class="home" style="display:none;">
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="home" href="https://theindicvoice.com/">Home</a>
                                </li>
                                <li>
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="about" href="https://theindicvoice.com/about">About</a>
                                </li>
                                <li>
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="contact us" href="https://theindicvoice.com/contact">Contact us</a>
                                </li>
                                <li>
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="newsletter" href="https://theindicvoice.com/newsletter">Newsletter</a>
                                </li>
                                <li>
                                    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="become a member" href="https://theindicvoice.com/write-for-us">Write For Us</a>
                                </li>
                                <!--<li>-->
                                <!--    <a data-ev-cat="nav" data-ev-act="left rail" data-ev-label="shop" href="https://theindicvoice.com/shop">Shop</a>-->
                                <!--</li>-->
                            </ul>
                            <div class="tabs-content nav-pills-tabs-content">
                                <div class="tab1 tabs first-tab padd-right-none" data-tab="tab2">
                                    <button class="btn btn-link btn-navbar-close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18.274" height="12.849" viewBox="0 0 18.274 12.849">
                                            <defs>
                                                <style>
                                                    .a {
                                                        fill: #000
                                                    }
                                                </style>
                                            </defs>
                                            <path class="a" d="M12.305,4.867a.648.648,0,1,0-.921.912l4.67,4.67H.645A.642.642,0,0,0,0,11.094a.649.649,0,0,0,.645.654h15.41l-4.67,4.661a.661.661,0,0,0,0,.921.645.645,0,0,0,.921,0l5.775-5.775a.634.634,0,0,0,0-.912Z" transform="translate(18.274 17.523) rotate(180)"></path>
                                        </svg>
                                        <span>ShortReads</span>
                                    </button>
                                    <style>.header-links li a:hover, .tabs-menu li a:hover{color: var(--iv-color-secondary);}</style>
                                    <ul class="header-links">
                                        <a data-ev-cat="nav" data-ev-act="channel" data-ev-label="ShortReads" href="https://theindicvoice.com/shortreads/" class="nav-channel-col" target="_blank">
                                            <div class="nav-channel-box">
                                              <div><img width="300" height="47" src="https://theindicvoice.com/assets/images/logo/logo-shortreads.svg" class="attachment-medium size-medium" alt="ShortReads Logo" decoding="async" sizes="(max-width: 300px) 100vw, 300px" /></div>
                                                <p>ShortReads</p>
                                            </div>
                                          </a>
                                    </ul>
                                </div>
                                <div class="tab2 tabs" data-tab="tab2">
                                    <button class="btn btn-link btn-navbar-close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18.274" height="12.849" viewBox="0 0 18.274 12.849">
                                            <defs>
                                                <style>
                                                    .a {
                                                        fill: #000
                                                    }
                                                </style>
                                            </defs>
                                            <path class="a" d="M12.305,4.867a.648.648,0,1,0-.921.912l4.67,4.67H.645A.642.642,0,0,0,0,11.094a.649.649,0,0,0,.645.654h15.41l-4.67,4.661a.661.661,0,0,0,0,.921.645.645,0,0,0,.921,0l5.775-5.775a.634.634,0,0,0,0-.912Z" transform="translate(18.274 17.523) rotate(180)"></path>
                                        </svg>
                                        <span>Topics</span>
                                    </button>
                                    <style>.header-links li a:hover, .tabs-menu li a:hover{color: var(--iv-color-secondary);}</style>
                                    <ul class="header-links">
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Economy" href="/Economy/">Economy</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Ayurveda" href="/Ayurveda/">Ayurveda</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Culture" href="/Culture/">Culture</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Culture" href="/Environment/">Environment</a>
                                        </li>
                                        <!--<li>-->
                                        <!--    <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Ganit" href="/Ganit/">Ganit</a>-->
                                        <!--</li>-->
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="History" href="/History/">History</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Literature" href="/Literature/">Literature</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Opinion" href="/Opinion/">Opinion</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Philosophy" href="/Philosophy/">Philosophy</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Politics" href="/Politics/">Politics</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Science" href="/Science/">Science</a>
                                        </li>
                                        <li>
                                            <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Society" href="/Society/">Society</a>
                                        </li>
                                        <!--<li>-->
                                        <!--    <a data-ev-cat="nav" data-ev-act="topics" data-ev-label="Yoga" href="/Yoga/">Yoga</a>-->
                                        <!--</li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-bottom-section">
                        <!--<div class="visible-xs mobile-login">-->
                        <!--    <h4>Already a member? <a class="login-button" href="">Log in</a>-->
                        <!--    </h4>-->
                        <!--</div>-->
                        <ul class="social-icons">
                            <li>
                                <a data-ev-cat="nav" data-ev-act="social" data-ev-label="instagram" class="social-link" href="https://www.instagram.com/theindicvoice_/" target="_blank">
                                    <img src="/assets/images/icons/instagram-icon.svg" alt="instagram-icon">
                                </a>
                            </li>
                            <li>
                                <a data-ev-cat="nav" data-ev-act="social" data-ev-label="twitter" class="social-link" href="https://twitter.com/theindicvoice" target="_blank">
                                    <img src="/assets/images/icons/twitter-icon.svg" alt="twitter-icon">
                                </a>
                            </li>
                            <li>
                                <a data-ev-cat="nav" data-ev-act="subscribe" href="/donate" target="_self" class="btn btn-secondary btn-pill btn-small visible-xs">Donate</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="search-collapse">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="main-logo align-items-center">
                                <a data-ev-cat="nav" data-ev-act="logo" href="<?php echo $logoLink; ?>">
                                    <img src="/assets/images/logo/<?php echo $logoFile; ?>" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <button class="btn btn-link btn-search-close">
                        <span>Close</span>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" viewBox="0 0 22 22">
                            <path id="circle" d="M0,11a11,11,0,0,1,22,0,11.11,11.11,0,0,1-6.787,10.164A10.588,10.588,0,0,1,11,22,11,11,0,0,1,0,11Zm11,9a9,9,0,1,1,6.364-2.636A9,9,0,0,1,11,20Z" fill="#000" fill-rule="evenodd"></path>
                            <path id="close" d="M9.34,2.322A1,1,0,1,0,7.976.859L5.05,3.587,2.322.66A1,1,0,0,0,.86,2.024L3.588,4.95.661,7.678A1,1,0,1,0,2.025,9.14L4.951,6.413,7.679,9.339A1,1,0,1,0,9.141,7.976L6.414,5.05Z" transform="translate(6.008 5.979)" fill="#000"></path>
                        </svg>
                    </button>
                    <div class="wrapper">
                        <!--<form role="search" method="get" class="search-form" action="/s">-->
                        <!--    <label>-->
                        <!--        <span class="screen-reader-text hidden">Search for:</span>-->
                        <!--        <input type="search" class="search-field aa-input" placeholder="Search …" value="" name="search" autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-2" dir="auto">-->
                        <!--        <pre aria-hidden="true" style="position:absolute;visibility:hidden;white-space:pre;font-family:&quot;font-style:normal;font-variant:normal;font-weight:400;word-spacing:0;letter-spacing:normal;text-indent:0;text-rendering:auto;text-transform:none"></pre>-->
                        <!--    </label>-->
                        <!--    <input type="submit" class="search-submit" value="Search">-->
                        <!--</form>-->
                        <style>.desktop-search{margin: 38px auto;}.desktop-search input{height:60px !important;}</style>
                        <form role="search" method="get" class="search-inp-wrap desktop-search" action="/s">
                        <label>
                            <span class="screen-reader-text"></span>
                            <input type="search" class="form-control aa-input" placeholder="Search The Indic Voice..." value="" name="search" autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto">
                            <pre aria-hidden="true" style="position:absolute;visibility:hidden;white-space:pre;font-family:&quot;font-style:normal;font-variant:normal;font-weight:400;word-spacing:0;letter-spacing:normal;text-indent:0;text-rendering:auto;text-transform:none"></pre>
                        </label>
                        <button type="submit" class="search-submit" value="Search">
                            <img src="/assets/images/icons/search-dark.svg" class="icon-search" alt="search icon" width="28" height="28">
                        </button>
                    </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <a data-ev-cat="nav" data-ev-act="logo" href="<?php echo $logoLink; ?>" class="main-logo">
                    <img src="/assets/images/logo/<?php echo $logoFile; ?>" alt="logo">
                </a>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 text-right">
                <a data-ev-cat="nav" data-ev-act="login" data-ev-label="click" class="btn btn-secondary btn-link white btn-small header-login-btn hidden-xs login-button" href="/write-for-us">Write For Us</a>
                <a data-ev-cat="nav" data-ev-act="subscribe" href="/donate" target="_self" class="btn btn-secondary btn-pill btn-small">Donate</a>
            </div>
        </div>
    </div>
</header>
<div class="main-header-placeholder"></div>