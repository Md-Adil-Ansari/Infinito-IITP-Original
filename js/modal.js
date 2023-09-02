const modalBtn1 = document.getElementById('modal-btn--1');
const modalBtn2 = document.getElementById('modal-btn--2');
const modalBtn3 = document.getElementById('modal-btn--3');
const modalBtn4 = document.getElementById('modal-btn--4');
const modalBtn5 = document.getElementById('modal-btn--5');
const modalBtn6 = document.getElementById('modal-btn--6');

const modal1 = document.getElementById('my-modal--1');
const modal2 = document.getElementById('my-modal--2');
const modal3 = document.getElementById('my-modal--3');
const modal4 = document.getElementById('my-modal--4');
const modal5 = document.getElementById('my-modal--5');
const modal6 = document.getElementById('my-modal--6');

const closeBtn1 = document.getElementById('close-btn--1');
const closeBtn2 = document.getElementById('close-btn--2');
const closeBtn3 = document.getElementById('close-btn--3');
const closeBtn4 = document.getElementById('close-btn--4');
const closeBtn5 = document.getElementById('close-btn--5');
const closeBtn6 = document.getElementById('close-btn--6');

openModal1 = (e)=>{
  modal1.style.display = 'block';
}
openModal2 = (e)=>{
  modal2.style.display = 'block';
}
openModal3 = (e)=>{
  modal3.style.display = 'block';
}
openModal4 = (e)=>{
  modal4.style.display = 'block';
}
openModal5 = (e)=>{
  modal5.style.display = 'block';
}
openModal6 = (e)=>{
  modal6.style.display = 'block';
}


closeModal1 = (e)=>{
  modal1.style.display = 'none';
}
closeModal2 = (e)=>{
  modal2.style.display = 'none';
}
closeModal3 = (e)=>{
  modal3.style.display = 'none';
}
closeModal4 = (e)=>{
  modal4.style.display = 'none';
}
closeModal5 = (e)=>{
  modal5.style.display = 'none';
}
closeModal6 = (e)=>{
  modal6.style.display = 'none';
}

outsideClick=(e)=>{
  switch(e.target){
    case modal1: modal1.style.display = 'none';break;
    case modal2: modal2.style.display = 'none';break;
    case modal3: modal3.style.display = 'none';break;
    case modal4: modal4.style.display = 'none';break;
    case modal5: modal5.style.display = 'none';break;
    case modal6: modal6.style.display = 'none';break;
  }
}
modalBtn1.addEventListener('click',openModal1,false);
modalBtn2.addEventListener('click',openModal2,false);
modalBtn3.addEventListener('click',openModal3,false);
modalBtn4.addEventListener('click',openModal4,false);
modalBtn5.addEventListener('click',openModal5,false);
modalBtn6.addEventListener('click',openModal6,false);

closeBtn1.addEventListener('click',closeModal1,false);
closeBtn2.addEventListener('click',closeModal2,false);
closeBtn3.addEventListener('click',closeModal3,false);
closeBtn4.addEventListener('click',closeModal4,false);
closeBtn5.addEventListener('click',closeModal5,false);
closeBtn6.addEventListener('click',closeModal6,false);

window.addEventListener('click', outsideClick);