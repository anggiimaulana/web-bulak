// document.addEventListener('DOMContentLoaded', function() {
//     let items = document.querySelectorAll('.box-info li');

//     items.forEach(function(item, index) {
//         if (index === 0) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/sku.php';
//             });
//         } else if (index === 1) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/skbn.php'
//             });
//         } else if (index === 2) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/sktm.php'
//             });
//         } else if (index === 3) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/skps.php'
//             });
//         } else if (index === 4) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/skd.php'
//             });
//         } else if (index === 5) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/sk.php'
//             });
//         } else if (index === 6) {
//             item.addEventListener('click', function() {
//                 window.location.href = 'pengajuan/skpot.php'
//             });
//         } else {
//             item.addEventListener('click', function() {
//                 let jenis = item.getAttribute('data-jenis');
//                 window.location.href = 'pengajuan.php?jenis=' + jenis;
//             });
//         }
//     });
// });

// lebih simple cuyy

document.addEventListener('DOMContentLoaded', function() {
    let items = document.querySelectorAll('.box-info li');

    items.forEach(function(item) {
        item.addEventListener('click', function() {
            let jenis = item.getAttribute('data-jenis');
            window.location.href = 'pengajuan/' + jenis + '.php';
        });
    });
});
