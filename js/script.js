// document.addEventListener('DOMContentLoaded', (event) => {
//    let menu = document.querySelector('#menu-btn');
//    let navbar = document.querySelector('.header .navbar');

//    if (menu && navbar) {
//        menu.onclick = () => {
//            menu.classList.toggle('fa-times');
//            navbar.classList.toggle('active');
//        };

//        window.onscroll = () => {
//            menu.classList.remove('fa-times');
//            navbar.classList.remove('active');
//        };
//    } else {
//        console.error('Menu button or navbar element not found');
//    }
// });



document.addEventListener('DOMContentLoaded', () => {
   let menu = document.querySelector('#menu-btn');
   let navbar = document.querySelector('.header .navbar');

   if (menu && navbar) {
       menu.onclick = () => {
           menu.classList.toggle('fa-times');
           navbar.classList.toggle('active');
       };

       window.onscroll = () => {
           menu.classList.remove('fa-times');
           navbar.classList.remove('active');
       };
   } else {
       console.error('Menu button or navbar element not found');
   }
});


document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'admin.php';
};
function confirmDelete(id) {
   if (confirm('Are you sure you want to delete this item?')) {
       window.location.href = 'admin.php?delete=' + id;
       return true;
   }
   return false;
}

$(document).ready( function () {
    $('#productTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });
});