function createFormData(data){
  let formData = new FormData();
  for (let key in data) {
    formData.append(key, data[key]);
  }
  return formData;
}

function getServiceName(id,services){
  let service = services.find(service => service.id == id);
  return service ? service.service_name : '';
}

function getCategoryName(id,categories){
  let category = categories.find(category => category.id == id);
  return category ? category.category_name : '';
}


function swalSuccess(message){
  Swal.fire({
    title: message,
    position: "top",
    icon: "success",
    showConfirmButton: false,
    timer: 1000
  });
}

function swalConfirm(message){
  return Swal.fire({
    title: message,
    position: "top",
    showDenyButton: true,
    confirmButtonText: "はい",
    denyButtonText: "キャンセル",
  }).then((result) => {
    return result.isConfirmed;
  });
}

function swalError(message){
  Swal.fire({
    text: message,
    position: "top",
    icon: "error",
    showConfirmButton: false,
    timer: 1000
  });
}




function mousedragscrollable(element){
  let target;
  const elms = document.querySelectorAll(element);
  for(let i=0; i<elms.length; i++){
    elms[i].addEventListener('mousedown', function(evt){
      let tagName = evt.target.tagName;
      if(tagName === 'INPUT' || tagName === 'SELECT' || tagName === 'TEXTAREA') return;
      evt.preventDefault();
      target = elms[i];
      target.dataset.down = 'true';
      target.dataset.move = 'false';
      target.dataset.x = evt.clientX;
      target.dataset.y = evt.clientY;
      target.dataset.scrollleft = target.scrollLeft;
      target.dataset.scrolltop = target.scrollTop;
      evt.stopPropagation();
    });
    elms[i].addEventListener('click', function(evt){
      if(elms[i].detaset != null && elms[i].detaset.move == 'true') evt.stopPropagation();
    });
  }
  document.addEventListener('mousemove', function(evt){
    if(target != null && target.dataset.down == 'true'){
      evt.preventDefault();
      let move_x = parseInt(target.dataset.x) - evt.clientX;
      let move_y = parseInt(target.dataset.y) - evt.clientY;
      if (move_x !== 0 || move_y !== 0) {
        target.dataset.move = 'true';
      } else {
        return;
      }
      target.scrollLeft = parseInt(target.dataset.scrollleft) + move_x;
      target.scrollTop = parseInt(target.dataset.scrolltop) + move_y;
      evt.stopPropagation();
    }
  });
  document.addEventListener('mouseup', function(evt){
    if(target != null && target.dataset.down == 'true'){
      target.dataset.down = 'false';
      evt.stopPropagation();
    }
  });
}





