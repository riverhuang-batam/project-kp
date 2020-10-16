async function showDialog(title, text, icon){
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary m-2',
      cancelButton: 'btn btn-danger m-2'
    },
    buttonsStyling: false
  })
  let result = await swalWithBootstrapButtons.fire({
    title: title,
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonText: 'Yes, continue!',
    cancelButtonText: 'No, cancel!',
  });

  if(result.isConfirmed){
    return true;
  }else{
    return false;
  }
}

function showAlert(title, text){
  Swal.fire(
    title,
    text,
    'info'
  )
}