let textarea_height = '30px';
document.addEventListener('DOMContentLoaded', function(){
  let click = new clickBtn();
  let comment = new Comment();
  click.view_reply();

  qselect('.board').addEventListener('click', function(btn){

    if (btn.target.classList.contains('comment-main__reply-btn')){
      click.show_main(btn.target, '.comment-sub__create', 'show-sub')

    }else if (btn.target.classList.contains('comment-main__edit-btn')){
      click.show_main(btn.target, '.comment-main__edit', 'show-sub')
    }else if (btn.target.classList.contains('comment-sub__edit-btn')){
      click.show_sub(btn.target, '.comment-sub__edit', 'show-sub')
    }

    else if (btn.target.classList.contains('comment-sub__create--cancel')){
      click.cancel(btn.target, 'show-sub')
    }else if (btn.target.classList.contains('comment-main__edit--cancel')){
      click.cancel(btn.target, 'show-sub')
    }else if (btn.target.classList.contains('comment-sub__edit--cancel')){
      click.cancel(btn.target, 'show-sub')
    }

    else if (btn.target.classList.contains('comment-main__delete-btn')){
      comment.delete(btn.target);
    }else if (btn.target.classList.contains('comment-sub__delete-btn')){
      comment.delete(btn.target);
    }

    else if (btn.target.classList.contains('board__create--submit')){
      comment.create_main(btn.target, '.board__create--msg')
    }else if (btn.target.classList.contains('comment-sub__create--submit')){
      comment.create_sub(btn.target, '.comment-sub__create--msg')
    }

    else if (btn.target.classList.contains('comment-main__edit--submit')){
      comment.edit(btn.target, '.comment-main')
    }else if (btn.target.classList.contains('comment-sub__edit--submit')){
      comment.edit(btn.target, '.comment-sub')
    }

    else if(btn.target.classList.contains('comment-sub__create--msg')){
      textarea_autosize(btn.target);
    }else if(btn.target.classList.contains('comment-main__edit--msg')){
      textarea_autosize(btn.target);
    }else if(btn.target.classList.contains('comment-sub__edit--msg')){
      textarea_autosize(btn.target);
    }

  })
})




function Comment(){
  this.delete = function(target){
    let id = parseInt(target.getAttribute('data-id'));
    let parent_ele = target.parentElement;
    let parent_class = parent_ele.classList[1];

    if(id >= 0){
      if (confirm('Delet the comment?')){

        const request = new XMLHttpRequest();
        request.open('POST', './delete_comment.php');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send("id="+id); //送出 POST 數據，須設定數據名稱

        request.onload = function(){
          if (request.status >= 200 && request.status < 400){
            let resp = JSON.parse(request.response)
            if (resp.result == 'success'){
              if (parent_class == 'comment-main'){
                parent_ele.parentElement.outerHTML =
                `<div class='` + parent_class + '__deleted'
                + ' '  + 'deleted_' + id  +`'>This comment has been deleted.</div>`;
                setTimeout(function(){
                  qselect('.' + 'deleted_' + id ).style.display = 'none';
                }, 3000);
              }else if (parent_class == 'comment-sub'){
                parent_ele.innerHTML =
                `<div class='` + parent_class + '__deleted' + `'>This comment has been deleted.</div>`;
                setTimeout(function(){
                  parent_ele.style.display = 'none';
                }, 3000);
              }
            }else if(resp.result == 'warning'){
              alert('Not allow to delete this comment');
            }
          }
          else{
            alert('Delete Failed!');
          }
        }
      }
    }else{
      alert('Error, please try again');
    }
  }

  this.create_main = function(btn, target_comment){
    let parent_ele = btn.parentElement
    let parent_id = parent_ele.querySelector('.parent_id').value;
    let name = parent_ele.querySelector('.board__create--profile').querySelector('.board__create--profile-nickname').innerText;
    let comment = parent_ele.querySelector(target_comment).value;

    if (comment.trim() !== ''){
      const request = new XMLHttpRequest();
      request.open('POST', './create_comment.php');
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send("comment=" + comment + "&" + "parent_id=" + parent_id);
      request.onload = function(){
        if (request.status >= 200 && request.status < 400){
          console.log(request.response)
          let resp = JSON.parse(request.response)
          if (resp.result == 'success'){
            let new_main =
            `
            <div class='board__comments--comment'>
              <div class='board__comments--comment-main comment-main'>
                <div class='comment-main__profile'>
                  <div class='comment-main__profile--pic'>
                    `  + name[0].toUpperCase() +  `
                  </div>
                  <div class='comment-main__profile--nickname'>
                    `  + name +  `
                  </div>
                </div>
                <div class='comment-main__msg'>
                  `  + escape(comment) +  `
                </div>
                <span class='comment-main__created-at'>
                  `  + 'now' +  `
                </span>

                <button class='comment-main__edit-btn comment-main__btn'>
                  Edit
                </button>
                <button class='comment-main__delete-btn comment-main__btn' data-id='` + resp.id + `'>
                  Delete
                </button>

                <button class='comment-main__reply-btn comment-main__btn'>
                      REPLY
                </button>

                <button class='comment-main__view-reply-btn comment-main__btn'>
                  <span class='comment-main__view-reply-btn--span-noreply'>no reply</span>
                </button>
              </div>
              <form method='POST' class='comment-main__edit'>
                <div class='comment-main__edit--profile'>
                  <div class='comment-main__edit--profile-nickname'>
                    `  + name +  `
                  </div>
                </div>
                <textarea class='comment-main__edit--msg' name='comment' required=''>`  + escape(comment) +  `</textarea>
                <input class='id' type='hidden' name='id' value='` + resp.id + `' />
                <div class='comment-main__edit--cancel'>CANCEL</div>
                <input type='button' value='EDIT' class='comment-main__edit--submit'></input>
              </form>
              <form method='POST' class='comment-sub__create'>
                <div class='comment-sub__create--profile'>
                  <div class='comment-sub__create--profile-nickname'>
                  `  + name +  `
                  </div>
                </div>
                <textarea class='comment-sub__create--msg' value='' placeholder='Leave your message here' name='comment' required=''></textarea>
                <input type='hidden' name='parent_id' class='parent_id' value='` + resp.id + `' />
                <div class='comment-sub__create--cancel'>CANCEL</div>
                <input type='button' value='COMMENT' class='comment-sub__create--submit'></input>
              </form>
            </div>
            `
            let board = document.querySelector('.board__comments--pages')
            board.insertAdjacentHTML('afterend', new_main)
            parent_ele.querySelector(target_comment).value = '';
          }
        }
      }
    }else{
      if (btn.innerText !== 'LOG IN'){
        alert('請輸入內容');
      }
    }
  }

  this.create_sub = function(btn, target_comment){
    let parent_ele = btn.parentElement
    let parent_id = parent_ele.querySelector('.parent_id').value;
    let name = parent_ele.querySelector('.comment-sub__create--profile-nickname').innerText;
    let comment = parent_ele.querySelector(target_comment).value;

    if (comment.trim() !== ''){
      const request = new XMLHttpRequest();
      request.open('POST', './create_comment.php');
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send("comment=" + comment + "&" + "parent_id=" + parent_id);
      request.onload = function(){
        if (request.status >= 200 && request.status < 400){
          let resp = JSON.parse(request.response)
          if (resp.result == 'success'){
            let new_sub =
            `
            <div class='board__comments--comment-sub comment-sub' style='display: grid'>
              <div class='comment-sub__profile'>
                <div class='comment-sub__profile--pic'>
                  `  + name[0].toUpperCase() +  `
                </div>
                <div class='comment-sub__profile--nickname'>
                  `  + name +  `
                </div>
              </div>
              <div class='comment-sub__msg'>
                `  + escape(comment) +  `
              </div>
              <span class='comment-sub__created-at'>
                now
              </span>

              <button class='comment-sub__edit-btn comment-main__btn'>
                Edit
              </button>
              <button class='comment-sub__delete-btn comment-main__btn' data-id='` + resp.id + `'>
                Delete
              </button>
            </div>
            <form method='POST' class='comment-sub__edit'>
              <div class='comment-sub__edit--profile'>
                <div class='comment-sub__edit--profile-nickname'>
                  `  + name +  `
                </div>
              </div>
              <textarea class='comment-sub__edit--msg' name='comment' required=''>`  + escape(comment) +  `</textarea>
              <input class='id' type='hidden' name='id' value='` + resp.id + `' />
              <div class='comment-sub__edit--cancel'>CANCEL</div>
              <input type='button' value='EDIT' class='comment-sub__edit--submit'></input>
            </form>
            `

            let board = parent_ele.parentElement.querySelector('.comment-sub__create')
            board.insertAdjacentHTML('afterend', new_sub);
            parent_ele.querySelector(target_comment).value = '';
            parent_ele.querySelector(target_comment).style.height = textarea_height;
            parent_ele.classList.toggle('show-sub');
          }
        }
      }
    }else{
      alert('請輸入內容');
    }
  }

  this.edit = function(btn, edit){
    let new_msg = btn.parentElement.classList[0] + '--msg';
    let edit_msg = edit + '__msg';
    let request = new XMLHttpRequest();
    let parent_ele = btn.parentElement;
    let comment = parent_ele.querySelector('.'+ new_msg).value;
    let comment_edit = parent_ele.previousElementSibling.querySelector(edit_msg)
    let id = btn.parentElement.querySelector('.id').value;

    if (comment.trim() !== ''){
      request.open('POST', './edit_comment.php');
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
      request.send("comment=" + comment + "&" + "id=" + id);

      request.onload = function(){
        if (request.status >= 200 && request.status < 400){
          console.log(request.response);
          let resp = JSON.parse(request.response)
          if (resp.result == 'success'){
            comment_edit.innerText = comment;
            parent_ele.querySelector('.'+ new_msg).style.height = textarea_height;
            parent_ele.classList.toggle('show-sub');
          }else if(resp.result == 'warning'){
            alert('Not allow to edit this comment')
          }
        }else{
          alert('edit failed');
        }

      }
    }else{
      alert('請輸入內容');
    }
  }
}

function qselect(target){
  return document.querySelector(target);
}

function readCookie(name) {
   var nameEQ = name + "=";
   var ca = document.cookie.split(';');
   for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
   }
   return null;
}

function clickBtn(){
  this.cancel = function(btn, toggle_class){
    btn.parentElement.classList.toggle(toggle_class);
  }

  this.show_main = function(btn, target, toggle_class){
    btn.parentElement.parentElement.querySelector(target).classList.toggle(toggle_class)
  }

  this.show_sub = function(btn, target, toggle_class){
    btn.parentElement.nextElementSibling.classList.toggle(toggle_class)
  }

  this.view_reply = function(){
    let view_reply_btn = document.querySelectorAll('.comment-main__view-reply-btn');
    for (let num = 0; num < view_reply_btn.length; num++){
      let sub_len = view_reply_btn[num].parentElement.parentElement.querySelectorAll('.comment-sub').length;
      if (sub_len === 0){
        view_reply_btn[num].innerHTML =
        `<span class='comment-main__view-reply-btn--span-noreply'>no reply</span>`;
        view_reply_btn[num].style.cursor = 'default';
      }
      else if (sub_len === 1){
        view_reply_btn[num].innerHTML =
        `<span class='comment-main__view-reply-btn--span'>` + sub_len + ` reply</span><i class="fas fa-angle-down"></i>`;
      }else{
        view_reply_btn[num].innerHTML =
        `<span class='comment-main__view-reply-btn--span'>` + sub_len + ` repies</span><i class="fas fa-angle-down"></i>`;
      }

      if (sub_len > 0){
        view_reply_btn[num].addEventListener('click', function(){
          this.querySelector('.fa-angle-down').classList.toggle('show-sub'); // 箭頭 icon 方向轉換 // 子留言回復表格顯示
          let sub = this.parentElement.parentElement.querySelectorAll('.comment-sub');
          for(let i = 0; i< sub.length; i++){
            sub[i].classList.toggle('show-sub'); //顯示全部 sub comments
          }
        })
      }
    }
  }
}

function textarea_autosize(target){
  target.style.height = textarea_height;
  target.style.height = target.scrollHeight + 'px';
  target.addEventListener('keyup', function(){
    this.style.height = textarea_height; // 把高度歸零
    this.style.height = this.scrollHeight + 'px'; // 再根據目前 scrollHeight，調整 textarea 的高度

  })
}

function escape(str){
  let escape_str =
  str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;")
    .replace(/\n/g, "<br />");
  return escape_str
}
