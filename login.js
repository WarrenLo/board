document.addEventListener('DOMContentLoaded',function(){
  document.querySelector('.login__input--eye').addEventListener('click', function(){
    let target = this.parentElement.querySelector('.login__input--input')
    console.log(this.innerHTML)
    if(target.type === 'password'){
      target.type = 'text';
      this.innerHTML = `<i class="fas fa-eye-slash"></i>`;
    }else if(target.type === 'text'){
      target.type = 'password';
      this.innerHTML = `<i class="fas fa-eye"></i>`;
    }
  })
})
