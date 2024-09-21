document.getElementById("showSignupForm").onclick = function() {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("signupForm").style.display = "block";
}

document.getElementById("showLoginForm").onclick = function() {
    document.getElementById("signupForm").style.display = "none";
    document.getElementById("loginForm").style.display = "block";
}

/*LOGOUT*/

function logout() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            window.location.href = 'home.php';
        }
    };

    xhr.send("action=logout");
}
/*MANAGE CARS*/

function showAddCarDialog() {
    document.getElementById("addCarDialog").style.display = "block";
}

function closeAddCarDialog() {
    document.getElementById("addCarDialog").style.display = "none";
}

function showUpdateCarDialog(button) {
    var row = button.parentElement.parentElement;
    var id = row.getElementsByTagName('td')[0].innerText;


    document.getElementById("update_id").value = id;
    document.getElementById("update_brand").value = row.cells[1].innerText;
    document.getElementById("update_model").value = row.cells[2].innerText;
    document.getElementById("update_year").value = row.cells[3].innerText;
    document.getElementById("update_color").value = row.cells[4].innerText;
    document.getElementById("update_mileage").value = row.cells[5].innerText;
    document.getElementById("update_fuel_type").value = row.cells[6].innerText;
    document.getElementById("update_transmission_type").value = row.cells[7].innerText;
    document.getElementById("update_engine_capacity").value = row.cells[8].innerText;
    document.getElementById("update_price").value = row.cells[9].innerText;
    document.getElementById("update_sale_status").value = row.cells[10].innerText;
    document.getElementById("update_extra_features").value = row.cells[11].innerText;

    document.getElementById("updateCarDialog").style.display = "block";

}
function closeUpdateCarDialog() {
    document.getElementById("updateCarDialog").style.display = "none";
}

function submitUpdateCarForm() {
    var form = document.getElementById("updateCarForm");
    var formData = new FormData(form);
    formData.append("action", "updateVehicle");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            closeUpdateCarDialog();
            location.reload();
        }
    };

    xhr.send(formData);
}
function submitAddCarForm() {
    var form = document.getElementById("addCarForm");
    var formData = new FormData(form);
    formData.append("action", "addVehicle");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            closeAddCarDialog();
            location.reload();
        }
    };

    xhr.send(formData);
}

function deleteRow(button) {

    var row = button.parentElement.parentElement;
    var id = row.getElementsByTagName('td')[0].innerText;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {

            row.parentElement.removeChild(row);

        }
    };
    xhr.send("action=deleteVehicle&id=" + id);
}


/*MANAGE PROMOTIONS*/
function submitAddPromotionForm() {
    var form = document.getElementById("addPromotionForm");
    var formData = new FormData(form);
    formData.append("action", "addPromotion");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            closeAddPromotionDialog();
            location.reload();
        }
    };

    xhr.send(formData);
}

function showAddPromotionDialog() {
    document.getElementById("addPromotionDialog").style.display = "block";
}

function closeAddPromotionDialog() {
    document.getElementById("addPromotionDialog").style.display = "none";
}

function closeUpdatePromotionDialog() {
    document.getElementById("updatePromotionDialog").style.display = "none";
}

function submitUpdatePromotionForm() {
    var form = document.getElementById("updatePromotionForm");
    var formData = new FormData(form);
    formData.append("action", "updatePromotion");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            closeUpdatePromotionDialog();
            location.reload();
        }
    };

    xhr.send(formData);
}

function deletePromotion(button) {

    var row = button.parentElement.parentElement;
    var id = row.getElementsByTagName('td')[0].innerText;


    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {

            row.parentElement.removeChild(row);

        }
    };
    xhr.send("action=deletePromotion&id=" + id);
}
function showUpdatePromotionDialog(button) {
    var row = button.parentElement.parentElement;
    var id = row.getElementsByTagName('td')[0].innerText;

    document.getElementById("update_id").value = id;
    document.getElementById("update_promotion_name").value = row.cells[1].innerText;
    document.getElementById("update_description").value = row.cells[2].innerText;
    document.getElementById("update_start_date").value = row.cells[3].innerText;
    document.getElementById("update_end_date").value = row.cells[4].innerText;
    document.getElementById("update_discount_rate").value = row.cells[5].innerText;
    document.getElementById("update_usage_terms").value = row.cells[6].innerText;
    document.getElementById("update_is_active").checked = row.cells[7].innerText.toLowerCase() === 'true';
    document.getElementById("updatePromotionDialog").style.display = "block";
}

/* CARS*/
function submitAddRentForm() {
    var form = document.getElementById("rentalForm");
    var formData = new FormData(form);
    formData.append("action", "rentCar");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert("Successfully rented a car");
                closeRentCarDialog();
                window.location.href = 'home.php';
            } else {
                alert("Error occurred: " + xhr.responseText);
            }
        }
    };

    xhr.send(formData);
}


function updatePromotion() {
    var select = document.getElementById("promotions");
    var selectedPromotionID = select.options[select.selectedIndex].value;
    document.getElementById("selectedPromotionID").value = selectedPromotionID;
}

function closeRentCarDialog() {
    document.getElementById("rentCarDialog").style.display = "none";
    resetFormFields();
}

function showRentCarDialog(vehicleID, vehicleName, vehiclePrice, currentUser) {

    if (!currentUser){
        alert("you should login");
        window.location.href = "home.php";
    } else {
        document.getElementById("rentCarDialog").style.display = "block";
        document.getElementById("vehicleName").value = vehicleName;
        document.getElementById("vehicleID").value = vehicleID;
        document.getElementById("vehiclePrice").value = vehiclePrice;
        document.getElementById("rentalHeading").innerHTML = "Rent " + vehicleName;
        updatePaymentAmount();

    }

}

function resetFormFields() {
    document.getElementById("rentalForm").reset();
    document.getElementById("paymentAmount").value = "";
    updatePromotionTooltip();
}

function updatePromotionTooltip() {
    var promotionsDropdown = document.getElementById("promotions");
    var infoIcon = document.getElementById("infoIcon");
    var selectedPromotion = promotionsDropdown.options[promotionsDropdown.selectedIndex];
    var promotionDescription = selectedPromotion.title;
    infoIcon.setAttribute("title", promotionDescription);
}

function updatePaymentAmount() {
    var vehiclePrice = parseFloat(document.getElementById("vehiclePrice").value);
    var rentalDate = new Date(document.getElementById("rentalDateTime").value);
    var returnDate = new Date(document.getElementById("returnDateTime").value);
    var promotionDiscount = parseFloat(document.getElementById("promotions").options[document.getElementById("promotions").selectedIndex].getAttribute("data-discount"));

    if (!isNaN(rentalDate) && !isNaN(returnDate) && rentalDate <= returnDate) {
        var days = (returnDate - rentalDate) / (1000 * 60 * 60 * 24) + 1;
        var totalPrice = days * vehiclePrice;
        var discountedPrice = totalPrice * (1 - promotionDiscount / 100);
        document.getElementById("paymentAmount").value = discountedPrice.toFixed(2) + " TL";
    } else {
        document.getElementById("paymentAmount").value = "";
    }
}

