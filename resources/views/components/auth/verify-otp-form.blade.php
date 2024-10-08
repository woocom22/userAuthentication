<div class="container mt-5 pt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-4 shadow p-5 mb-5 bg-body rounded">

            <div class="mb-1">
                <label for="exampleInputEmail1" class="form-label">Enter OTP Code</label>
                <input id="OTP" type="OTP" name="OTP" class="form-control" >
            </div>

            <button onclick="verifyOTP()" type="submit" class="btn btn-primary mt-4">Submit</button>

        </div>
    </div>
</div>
<script>
    async function verifyOTP(){
        let OTP=document.getElementById('OTP').value;
        if(OTP.length!==4){
            errorToast('Enter your OTP Code')
        }
        else {
            showLoader();
            let res=await axios.post('/verify-otp',{
                OTP:OTP,
                email:sessionStorage.getItem('email')
            });
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message'])
                sessionStorage.clear();

                setTimeout(function (){
                    window.location.href="/resetPasswordPage";
                },1000)
            }
            else {
                errorToast(res.data['message']);
            }
        }
    }
</script>
