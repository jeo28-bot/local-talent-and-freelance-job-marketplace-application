<div id="meet" style="height: 100vh;"></div>

<script src="https://meet.jit.si/external_api.js"></script>

<script>
    const domain = "meet.jit.si";
    const roomName = "{{ $roomName }}";

    const options = {
        roomName,
        parentNode: document.querySelector('#meet'),
        width: "100%",
        height: "100%",
    };

    const api = new JitsiMeetExternalAPI(domain, options);
</script>
