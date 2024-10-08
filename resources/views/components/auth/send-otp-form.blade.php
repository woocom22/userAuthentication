<div class="container mt-5 pt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-4 shadow p-5 mb-5 bg-body rounded">

            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input id="email" type="email" name="email" class="form-control" >
            </div>

            <button onclick="sendCode()" type="submit" class="btn btn-primary mt-4">Sent Code</button>

        </div>
    </div>
</div>
<script>
    async function sendCode(){
        let email=document.getElementById('email').value;

        if(email===0){
            errorToast('Email is required')
        }
        else {
            showLoader();
            let res=await axios.post('/sent-otp',{email:email});
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message'])
                sessionStorage.setItem('email', email);
                setTimeout(function (){
                    window.location.href="/verify-OTP";
                },1000)
            }
            else {
                errorToast(res.data['message']);
            }
        }
    }
</script>
