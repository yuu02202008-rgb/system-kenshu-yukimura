import {fetchPosts, createPost} from './api.js';
const status=document.querySelector('#status');
document.querySelector('#load').addEventListener('click',async event=>{
 const button=event.currentTarget;button.disabled=true;status.textContent='取得中…';
 try {const posts=await fetchPosts();const list=document.querySelector('#posts');list.replaceChildren();for(const post of posts){const li=document.createElement('li');li.textContent=post.title;list.append(li);}status.textContent=`${posts.length}件取得`;}catch(error){status.textContent=error.message;}finally{button.disabled=false;}
});
document.querySelector('form').addEventListener('submit',async event=>{
 event.preventDefault();const form=event.currentTarget;const button=form.querySelector('button');button.disabled=true;status.textContent='送信中…';
 try{const result=await createPost({title:form.elements.title.value,body:'練習',userId:1});document.querySelector('#response').textContent=JSON.stringify(result,null,2);status.textContent='送信完了';}catch(error){status.textContent=error.message;}finally{button.disabled=false;}
});
