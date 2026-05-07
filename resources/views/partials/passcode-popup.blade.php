<div id="maskOverlay" style="position: fixed; z-index: 9999; background: rgba(0,0,0,0.8); width: 100%; height: 100%; top: 0; left: 0; display: flex; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 8px; text-align: center;">
        <h3>Enter Passcode</h3>
        <input type="password" id="passcodeInput" maxlength="4" style="letter-spacing: 10px; text-align: center; font-size: 24px;" />
        <br><br>
        <button onclick="verifyPasscode()" class="btn btn-danger">Submit</button>
        <p id="errorMsg" style="color: red; margin-top: 10px; display: none;">Invalid passcode!</p>
    </div>
</div>

<script>
    const correctPasscode = "1234"; // Change as needed

    function verifyPasscode() {
        const input = document.getElementById("passcodeInput").value;
        if (input === correctPasscode) {
            document.getElementById("maskOverlay").style.display = "none";
            document.body.style.overflow = "auto";
        } else {
            document.getElementById("errorMsg").style.display = "block";
        }
    }

    // Prevent scrolling while locked
    document.body.style.overflow = "hidden";
</script>
