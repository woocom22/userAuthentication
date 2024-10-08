<div class="container mt-5 pt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-4 shadow p-5 mb-5 bg-body rounded">

            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input id="email" type="email" name="email" class="form-control" >
            </div>
            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Password</label>
                <input id="password" type="password" name="password" class="form-control" >
            </div>
            <div class="d-flex justify-content-between">
                <button onclick="submitLogin()" type="submit" class="btn btn-primary mt-4">login</button>
                <button onclick="forgetPassword()" type="submit" class="btn btn-primary mt-4">Forget Password</button>
            </div>
        </div>
    </div>
</div>
<script>
    function forgetPassword() {
        window.location.href="/otp-send-page"
    }

    async function submitLogin() {
        let email=document.getElementById('email').value;
        let password=document.getElementById('password').value;

        if (email.length===0){
            errorToast('Email is required');
        }
        else if(password.length===0){
            errorToast('Password ir required');
        } else {
            showLoader();
            let res=await axios.post("/user-login",{email:email, password:password});
            hideLoader();
            if (res.status===200 && res.data['status']==='success'){
                successToast(res.data['message'])
                window.location.href="/dashboard"
            } else {
                errorToast(res.data['message']);
            }
        }
    }
</script>
