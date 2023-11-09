<!-- FIN DE SIDEBAR -->
</div>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<!-- page-wrapper -->

<script type="text/javascript">
  $(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
      if (
        $(this)
          .parent()
          .hasClass("active")
      ) {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }
});

$("#close-sidebar").click(function() {
  $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function() {
  $(".page-wrapper").addClass("toggled");
});

</script>
<?
/*******************************
 * Version : 1.0.0.0
 * Revised : jeudi 19 avril 2018, 16:44:07 (UTC+0200)
 *******************************/

if(isset($me)){
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 text-center">
            	Footer
            </div>
        </div>
    </div>
</footer>
<?}?>

<?
/* Bootstrap core JavaScript
==================================================
Placed at the end of the document so the pages load faster */ ?>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>


<script>window.jQuery || document.write('<script src="template/assets/lib/jquery-3.5.1/jquery-3.5.1.min.js"><\/script>')</script>
<?php //popper pour bootstrap tooltips ?>
<script src="/template/assets/lib/jquery-3.5.1/popper-2.7.0.min.js"></script>
<?php //Bootstrap 4 ?>
<script src="/template/assets/lib/bootstrap-4.5.3/js/bootstrap.min.js"></script>
<?php //checkbox look like ios button ?>
<script src="/template/assets/js/iosCheckbox.min.js"></script>
<script src="/template/assets/js/_common.js"></script>
<?php Core\Classes\Utils::debugTime(); ?>
</body>
</html>