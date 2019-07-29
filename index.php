<?php

if( isset($_GET['page']) ) {
    echo 'page';
} else {
    require 'public/views/front/homeView.phtml';
}