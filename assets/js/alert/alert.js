/*--------------- Delete Product Alert --------------------*/
function deleteProd() {
  var selectedIds = [];
  var checkboxes = document.querySelectorAll('input[name="product_checkbox[]"]:checked');

  checkboxes.forEach(function (checkbox) {
    selectedIds.push(checkbox.value);
  });

  if (selectedIds.length > 0) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: 'POST',
          url: '../pages/crudProd.php',
          data: {
            'delete_ids': selectedIds,
            'delete_btn': true
          },
          success: function (response) {
            console.log(response); // Log the response for debugging

            // Check if the response contains a success message
            if (response && response.toLowerCase().includes('success')) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              ).then(function () {
                location.reload();
              });
            } else {
              Swal.fire(
                'Error!',
                'Failed to delete selected items.',
                'error'
              );
            }
          }
        });
      }
    });
  } else {
    Swal.fire(
      'No items selected!',
      'Please select at least one item to delete.',
      'info'
    );
  }
}

/*--------------- Add Product Alert --------------------*/
function AddProd() {
  Swal.fire({
    title: 'Added!',
    text: 'Product added successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "product.php";
  });
};

/*--------------- Edit Product Alert --------------------*/
function EditProd() {
  Swal.fire({
    title: 'Updated!',
    text: 'Product updated successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "product.php";
  });
};

/* ------------- error alert ----------------- */

function ErrorAlert() {
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!'
  });
};

/*--------------- Add sub category Alert --------------------*/
function AddSubCateg() {
  Swal.fire({
    title: 'Added!',
    text: 'Sub Category added successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "sub_category.php";
  });
};

/*--------------- Delete Sub Categ Alert --------------------*/
function deleteSubCateg() {
  var selectedIds = [];

  // Find all checked checkboxes and get their values
  $('input[name="sCateg_checkbox[]"]:checked').each(function () {
    selectedIds.push($(this).val());
  });

  if (selectedIds.length > 0) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Debugging: Log the selected IDs before sending the request
        console.log('Selected IDs:', selectedIds);

        // Send an AJAX request to delete the selected checkboxes
        $.ajax({
          method: 'POST',
          url: '../pages/crudSubCateg.php',
          data: {
            's_categ_ids': selectedIds,
            'delete_btn': true
          },
          success: function (response) {
            console.log('Delete in SubCateg');

            if (response) {
              Swal.fire(
                "Deleted!",
                "Your files have been deleted.",
                "success"
              ).then(function () {
                // Reload the table content after successful deletion
                location.reload();
              });
            }
          },
          error: function (xhr, status, error) {
            console.log('AJAX Error:', xhr.responseText);
          }
        });
      }
    });
  } else {
    Swal.fire(
      'No items selected!',
      'Please select at least one item to delete.',
      'info'
    );
  }
}

/*--------------- Edit Sub-Category Alert --------------------*/
function EditSubCategory() {
  Swal.fire({
    title: 'Updated!',
    text: 'Sub category updated successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "sub_category.php";
  });
};

/*--------------- Add Main category Alert --------------------*/
function AddMainCateg() {
  Swal.fire({
    title: 'Added!',
    text: 'Main Category added successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "main_category.php";
  });
};

/*--------------- Edit Main category Alert --------------------*/
function EditMainCategory() {
  Swal.fire({
    title: 'Updated!',
    text: 'Main category updated successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "main_category.php";
  });
};

/*--------------- Delete Main Categ Alert --------------------*/
function deleteMainCateg() {
  $('.delete_btn').click(function () {
    var selectedIds = [];

    // Find all checked checkboxes and get their values
    $('input[name="mCateg_checkbox[]"]:checked').each(function () {
      selectedIds.push($(this).val());
    });

    if (selectedIds.length > 0) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Send an AJAX request to delete the selected checkboxes
          $.ajax({
            method: 'POST',
            url: '../pages/crudMainCateg.php',
            data: {
              'm_categ_ids': selectedIds,
              'delete_btn': true
            },
            success: function (response) {
              if (response) {
                Swal.fire(
                  "Deleted!",
                  "Your files have been deleted.",
                  "success"
                ).then(function () {
                  // Reload the table content after successful deletion
                  location.reload();
                });
              }
            }
          });
        }
      });
    } else {
      Swal.fire(
        'No items selected!',
        'Please select at least one item to delete.',
        'info'
      );
    }
  });
}

/* Function to update the sub_categ table */
function updateSubCateg($oldMCategoryName, $newMCategoryName, $conn) {
  $sql = "UPDATE sub_categ SET m_categ_name = '$newMCategoryName' WHERE m_categ_name = '$oldMCategoryName'";
  $sqlrun = mysqli_query($conn, $sql);

  if (!$sqlrun) {
    throw new Exception(mysqli_error($conn));
  }
}

/*--------------- Add Customer Alert --------------------*/
function AddCustomer() {
  Swal.fire({
    title: 'Registered!',
    text: 'You may now login!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "";
  });
};

/*--------------- Edit Customer Alert --------------------*/
function EditCustomer() {
  Swal.fire({
    title: 'Updated!',
    text: 'Product updated successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "customer.php";
  });
};

/*------- SQL ERRORS ----------*/
function ErrorPassword() {
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Password not match!'
  }).then(() => {
    $('#loginModal').modal('show');
  });
};

function ErrorLogin() {
  Swal.fire({
    title: 'Unsuccessful!',
    text: 'Invalid Credentials!',
    icon: 'error',
    showConfirmButton: true
  }).then(() => {
    $('#loginModal').modal('show');
  });
};

function ErrorPassMismatch() {
  Swal.fire({
    title: 'Error!',
    text: 'Old Password does not match the current password!',
    icon: 'error',
    showConfirmButton: true
  }).then(() => {
    $('#customerInfoModal').modal('show');
  });
};

function ErrorNewPasswordEmpty() {
  Swal.fire({
    title: 'Error!',
    text: 'New Password Field cannot be Empty!',
    icon: 'error',
    showConfirmButton: true
  }).then(() => {
    $('#customerInfoModal').modal('show');
  });
};

function ErrorOldPasswordEmpty() {
  Swal.fire({
    title: 'Error!',
    text: 'Old Password Field cannot be Empty!',
    icon: 'error',
    showConfirmButton: true
  }).then(() => {
    $('#customerInfoModal').modal('show');
  });
};

/*--------------- Successful Login Customer Alert --------------------*/
function loginCustomer() {
  Swal.fire({
    title: 'Successful!',
    text: 'You have successfully signed in!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    // Change the text of the navbar link with class 'navbar-categ' to 'Logout'
    $('.navbar-categ:contains("Login")').text('Logout');
    // Reload the page with a parameter indicating that the modal should be shown
    window.location.href = window.location.href + "?showModal=true";
  });
};

// In your document ready or another appropriate place
$(document).ready(function () {
  // Check if the URL contains the parameter 'showModal'
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('showModal')) {
    // Show the location search modal
    $('#locationModalContent').modal('show');
  }
});

function logoutCustomer() {
  Swal.fire({
    title: 'Logout',
    text: 'Are you sure you want to logout?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, logout'
  }).then(function (result) {
    if (result.isConfirmed) {
      // Perform AJAX call to logout
      $.ajax({
        type: 'POST',
        url: '../assets/php/extensions/session.php',
        data: { logout: true },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Session destroyed successfully, change navbar-categ text to 'Login'
            $('.navbar-categ:contains("Logout")').text('Login');
            window.location.href = "index.php";
          }
        },
        error: function () {
          // Handle error if needed
        }
      });
    }
  });
};


/*--------------- Customer Alert --------------------*/
function deleteCustomer() {
  var selectedIds = [];

  // Find all checked checkboxes and get their values
  $('input[name="cust_checkbox[]"]:checked').each(function () {
    selectedIds.push($(this).val());
  });

  if (selectedIds.length > 0) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Send an AJAX request to delete the selected checkboxes
        $.ajax({
          method: 'POST',
          url: '../pages/delCustomer.php',
          data: {
            'cust_ids': selectedIds,
            'delete_btn': true
          },
          success: function (response) {
            try {
              var jsonResponse = JSON.parse(response);
              jsonResponse.forEach(function (item) {
                if (item.status === 'success') {
                  // Handle success
                  Swal.fire(
                    'Deleted!',
                    'Selected items have been deleted.',
                    'success'
                  ).then(() => {
                    location.reload();
                  });
                } else {
                  // Handle error
                  Swal.fire(
                    'Error!',
                    'Failed to delete selected items. ' + item.message,
                    'error'
                  ).then(() => {
                  });
                }
              });
            } catch (error) {
              console.error('Error parsing JSON:', error);
              Swal.fire(
                'Error!',
                'Failed to delete selected items. Invalid response format.',
                'error'
              );
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            Swal.fire(
              'Error!',
              'Failed to delete selected items.',
              'error'
            );
          }
        });
      }
    });
  } else {
    Swal.fire(
      'No items selected!',
      'Please select at least one item to delete.',
      'info'
    );
  }
}




/************* ADMIN **************/
function loginAdmin() {
  Swal.fire({
    title: 'Successful!',
    text: 'You have successfully signed in!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "admin.php";
  });
};

function ErrLoginAdmin() {
  Swal.fire({
    title: 'Unsuccessful!',
    text: 'Invalid Credentials!',
    icon: 'error',
    showConfirmButton: true
  }).then(() => {
   
  });
};

function lockedAdmin() {
  Swal.fire({
    title: 'Warning!',
    text: 'Your Account is Currently Locked!',
    icon: 'error',
    showConfirmButton: true
  });
};

function logoutAdmin() {
  Swal.fire({
    title: 'Logout',
    text: 'Are you sure you want to logout?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, logout'
  }).then(function (result) {
    if (result.isConfirmed) {
      // Perform AJAX call to logout
      $.ajax({
        type: 'POST',
        url: '../assets/php/extensions/session.php',
        data: { logout: true },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Session destroyed successfully, change navbar-categ text to 'Login'
            window.location.href = "../pages/adminLogin.php";
          }
        },
        error: function () {
          // Handle error if needed
        }
      });
    }
  });
};

function AddAdmin() {
  Swal.fire({
    title: 'Registered!',
    text: 'Admin Successfully Created!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "admins.php";
  });
};

function DeleteAdmin() {
  var selectedIds = [];

  // Find all checked checkboxes and get their values
  $('input[name="admin_checkbox[]"]:checked').each(function () {
    selectedIds.push($(this).val());
  });

  if (selectedIds.length > 0) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Send an AJAX request to delete the selected checkboxes
        $.ajax({
          method: 'POST',
          url: '../pages/crudAdmin.php',
          data: {
            'admin_ids': selectedIds,
            'delete_btn': true
          },
          success: function (response) {
            location.reload();
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            Swal.fire(
              'Error!',
              'Failed to delete selected items.',
              'error'
            );
          }
        });
      }
    });
  } else {
    Swal.fire(
      'No items selected!',
      'Please select at least one item to delete.',
      'info'
    );
  }
}

function EditAdmin() {
  Swal.fire({
    title: 'Updated!',
    text: 'Admin updated successfully!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    
  });
};



/********* ORDERS *********/
function AddOrder() {
  Swal.fire({
    title: 'Successful!',
    text: 'Order Successfully Created!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "index.php";
  });
};

function EditOrder() {
  Swal.fire({
    title: 'Successful!',
    text: 'Order Successfully Updated!',
    icon: 'success',
    showConfirmButton: true
  }).then(function () {
    window.location.href = "order.php";
  });
};

function ErrOrder() {
  Swal.fire({
    title: 'Unsuccessful!',
    text: 'Order cannot be Created!',
    icon: 'error',
    showConfirmButton: true
  }).then(() => {

  });
};

function DeleteOrder() {
  var selectedIds = [];

  // Find all checked checkboxes and get their values
  $('input[name="order_checkbox[]"]:checked').each(function () {
    selectedIds.push($(this).val());
  });

  if (selectedIds.length > 0) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Send an AJAX request to delete the selected checkboxes
        $.ajax({
          method: 'POST',
          url: '../pages/crudOrder.php',
          data: {
            'order_ids': selectedIds,
            'delete_btn': true
          },
          success: function (response) {
            try {
              var jsonResponse = JSON.parse(response);
              jsonResponse.forEach(function (item) {
                if (item.status === 'success') {
                  // Handle success
                  Swal.fire(
                    'Deleted!',
                    'Selected items have been deleted.',
                    'success'
                  ).then(() => {
                    location.reload();
                  });
                } else {
                  // Handle error
                  Swal.fire(
                    'Error!',
                    'Failed to delete selected items. ' + item.message,
                    'error'
                  ).then(() => {
                  });
                }
              });
            } catch (error) {
              console.error('Error parsing JSON:', error);
              Swal.fire(
                'Error!',
                'Failed to delete selected items. Invalid response format.',
                'error'
              );
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            Swal.fire(
              'Error!',
              'Failed to delete selected items.',
              'error'
            );
          }
        });
      }
    });
  } else {
    Swal.fire(
      'No items selected!',
      'Please select at least one item to delete.',
      'info'
    );
  }
}
