   // Input fields

const deliveryFee = document.getElementById('delivery_fee');
const deliveryCity = document.getElementById('delivery_city');
 
   // Form
const editform = document.getElementById('editFrom');

  // Handle form 
editform.addEventListener('submit', function(event) {
  
  // Prevent default behaviour
    event.preventDefault();
    if (
      validateDeliveryCity() &&
      validateDeliveryFee()
    ) {
      editform.submit();
    }
  });

  // Validators
function validateDeliveryCity() {
 
    if (checkIfEmpty(deliveryCity)) return;

    if (!checkIfOnlyLetters(deliveryCity)) return;
    return true;
 //check whether a valid text field

}


function validateDeliveryFee() {
 
    if (checkIfEmpty(deliveryFee)) return;

    if (!checkIfOnlyPrice(deliveryFee)) return;
    return true;
  //check whether a valid amount

}