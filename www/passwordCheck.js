class PasswordValidator{
  constructor(pwd1id,pwd2id,noteId,butId){
    this.pwd1=document.getElementById(pwd1id);
    this.pwd2=document.getElementById(pwd2id);
    this.message=document.getElementById(noteId);
    this.saveBut=document.getElementById(butId);
    this.pwd1.oninput =this.compareElementValues.bind(this);
    this.pwd2.oninput =this.compareElementValues.bind(this);
  }
  compareElementValues(){
    if(this.pwd1.value!=this.pwd2.value){
      this.message.innerHTML="Passwords missmatch";
      this.message.style.display="block";
      this.saveBut.style.display="none";
    }else{
      this.message.innerHTML="";
      this.message.style.display="none";
      this.saveBut.style.display="block";
    }
  }
}