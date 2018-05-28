<!DOCTYPE html>
<html>

<head>
  <title>Classroom Air</title>
  <style>
    #loader {
      transition: all .3s ease-in-out;
      opacity: 1;
      visibility: visible;
      position: fixed;
      height: 100vh;
      width: 100%;
      background: #fff;
      z-index: 90000
    }

    #loader.fadeOut {
      opacity: 0;
      visibility: hidden
    }

    .spinner {
      width: 40px;
      height: 40px;
      position: absolute;
      top: calc(50% - 20px);
      left: calc(50% - 20px);
      background-color: #333;
      border-radius: 100%;
      -webkit-animation: sk-scaleout 1s infinite ease-in-out;
      animation: sk-scaleout 1s infinite ease-in-out
    }

    @-webkit-keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0)
      }
      100% {
        -webkit-transform: scale(1);
        opacity: 0
      }
    }

    @keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0)
      }
      100% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
      }
    }
  </style>
  <link href="./style.css" rel="stylesheet">
  <script type="text/javascript" src="./vendor.js"></script>
  <script type="text/javascript" src="./bundle.js"></script>
  <script type="text/javascript" src="assets/chart.js"></script>
  <script type="text/javascript" src="assets/utils.js"></script>
  <script type="text/javascript" src="assets/timeago.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body class="app">
  <div id="loader">
    <div class="spinner"></div>
  </div>
  <script type="text/javascript">
    window.addEventListener('load', () => {
      const loader = document.getElementById('loader');
      setTimeout(() => {
        loader.classList.add('fadeOut');
      }, 300);
    });
  </script>
  <div>
    <div class="sidebar">
      <div class="sidebar-inner">
        <div class="sidebar-logo">
          <div class="peers ai-c fxw-nw">
            <div class="peer peer-greed">
              <a class="sidebar-link td-n" href="./index.html" class="td-n">
                <div class="peers ai-c fxw-nw">
                  <div class="peer">
                    <div class="logo"><img src="assets/static/images/logo.png" alt=""></div>
                  </div>
                  <div class="peer peer-greed">
                    <h5 class="lh-1 mB-0 logo-text">Classroom Air</h5></div>
                </div>
              </a>
            </div>
            <div class="peer">
              <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a></div>
            </div>
          </div>
        </div>
        <ul class="sidebar-menu scrollable pos-r">
          <li class="nav-item mT-30 active"><a class="sidebar-link" href="./" default><span class="icon-holder"><i class="c-blue-500 ti-home"></i> </span><span class="title">Dashboard</span></a></li>
          <li class="nav-item"><a class="sidebar-link" href="charts.php"><span class="icon-holder"><i class="c-indigo-500 ti-bar-chart"></i> </span><span class="title">Charts</span></a></li>
          <li class="nav-item"><a class="sidebar-link" href="prediction.php"><span class="icon-holder"><i class="c-green-500 ti-light-bulb"></i> </span><span class="title">Predictions</span></a></li>
          <li class="nav-item"><a class="sidebar-link" href="real.php"><span class="icon-holder"><i class="c-red-500 ti-time"></i> </span><span class="title">Real Time Chart</span></a></li>

        </ul>
      </div>
    </div>
    <div class="page-container">
      <div class="header navbar">
        <div class="header-container">
          <ul class="nav-left">
            <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a></li>
            <li class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);"><i class="search-icon ti-search pdd-right-10"></i> <i class="search-icon-close ti-close pdd-right-10"></i></a></li>
            <li class="search-input"><input class="form-control" type="text" placeholder="Search..."></li>
          </ul>

          <ul class="nav-right">
            <li class="dropdown">
              <div class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" style="color: #72777a;display: block;line-height: 65px;min-height: 65px;padding: 0 15px;-webkit-transition: all .2s ease-in-out;-o-transition: all .2s ease-in-out;transition: all .2s ease-in-out;" >
                <div class="peer"><span class="fsz-sm c-grey-900"><b>CmpE 490 IOT Project</b>&nbsp;&nbsp;</span></div>

              </div>
              <ul class="dropdown-menu fsz-sm">
                <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-settings mR-10"></i> <span>Setting</span></a></li>
                <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-user mR-10"></i> <span>Profile</span></a></li>
                <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-email mR-10"></i> <span>Messages</span></a></li>
                <li role="separator" class="divider"></li>
                <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-power-off mR-10"></i> <span>Logout</span></a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>

      <main class="main-content bgc-grey-100">
