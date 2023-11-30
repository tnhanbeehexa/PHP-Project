document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const searchValue = searchInput.value.trim();
            if (searchValue !== '') {
                window.location.href = `http://localhost/Notyet/index.php?controller=product&action=search&search=${searchValue}`;
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var userDropdown = document.getElementById("userDropdown");
    var userDropdownContent = document.getElementById("userDropdownContent");

    userDropdown.addEventListener("click", function(event) {
        // Ngăn chặn hành vi mặc định của liên kết
        event.preventDefault();

        // Toggle hiển thị dropdown-content
        if (userDropdownContent.style.display === "block") {
            userDropdownContent.style.display = "none";
        } else {
            userDropdownContent.style.display = "block";
        }
    });

    userDropdownContent.addEventListener("click", function(event) {
        console.log("user dropdown");
        event.stopPropagation();
    });

    // Khi click vào những mục trong phần payment thì những mục đó được gán class active
    const cart_items_status = document.querySelectorAll('.cart_item_status');
    console.log(cart_items_status);
    cart_items_status.forEach((currentValue, index) => {
        
        currentValue.onclick = (e) => {
            cart_items_status.forEach(item => {
                item.classList.remove('active');
            })
            e.target.classList.add('active');
        }
    })
});
