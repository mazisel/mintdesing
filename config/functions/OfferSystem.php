<?php

function StarHtml($puan)
  {
    switch ($puan) {
      case '1': echo '<span class="star1"><i class="fas fa-star"></i></span>';  break;
      case '2': echo '<span class="star2"><i class="fas fa-star"></i><i class="fas fa-star"></i></span>'; break;
      case '3': echo '<span class="star3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>';  break;
      case '4': echo '<span class="star4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>'; break;
      case '5': echo '<span class="star5"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>'; break;                        
      default:  break;
    }
  }

function StarHtml2($puan)
{
  switch ($puan) {
    case '1': echo '<li><a href="#"><i class="bi bi-star-fill"></i></a></li>';  break;
    case '2': echo '<li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>'; break;
    case '3': echo '<li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>';  break;
    case '4': echo '<li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>'; break;
    case '5': echo '<li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>
                  <li><a href="#"><i class="bi bi-star-fill"></i></a></li>'; break;                        
    default:  break;
  }
}