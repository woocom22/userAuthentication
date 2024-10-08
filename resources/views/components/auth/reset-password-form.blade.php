<div class="container mt-5 pt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-4 shadow p-5 mb-5 bg-body rounded">

            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Password</label>
                <input id="password" type="password" name="password" class="form-control" >
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Conform Password</label>
                <input id="cPassword" type="password" name="password" class="form-control" >
            </div>
            <button onclick="submitPassword()" type="submit" class="btn btn-primary mt-4">login</button>

        </div>
    </div>
</div>
<script>
    async function submitPassword(){
        let password=document.getElementById('password').value;
        let cPassword=document.getElementById('cPassword').value;
        if(password.length===0){
            errorToast('Password is required')
        } else if(cPassword.length===0){
            errorToast('Conform password is required')
        } else if(password!==cPassword){
            errorToast('Password and conform Password are not same')
        }
        else {
            showLoader();
            let res=await axios.post("/reset-password",{password:password})
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                setTimeout(function (){
                    window.location.href="/loginPage";
                },1000)
            }
            else {
                errorToast(res.data['message'])
            }
        }
    }

</script>



































