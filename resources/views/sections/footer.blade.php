      <!-- This example requires Tailwind CSS v2.0+ -->

      <script>
  var button = document.getElementById("main-menu");
  button.addEventListener("click", function(event) { 
    console.log("I hear your calls");
    event.stopPropagation();
    toggleMobMenu();
  });
  window.addEventListener("click", function(event) {
  var hid_menu = document.getElementById("mobmenu");
  var target = String(event.target);
  console.log("Target variable is: ");
  console.log(target);
  if(!hid_menu.classList.contains("hidden")) {
    console.log('The menu is not hidden and the event target is: ');
    console.log(event.target);
    hid_menu.classList.toggle("hidden"); // crashes when I add this line
    
} });
  function toggleMobMenu() {
   var element = document.getElementById("mobmenu");
   element.classList.toggle("hidden");
}
  </script>
  <center style="padding:40px;">Copyright Rent Roll Devour System 2022 </center>
    </body>
</html>