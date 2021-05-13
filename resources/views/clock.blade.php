<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
<style>

    .clock {
        transform: translateX(0) translateY(-50%);
        color: blue;
        font-size: 40px;
        letter-spacing: 5px;
    }
</style>


<div class="container">
    <table class="w3-table">
        <tr>
            <td class="w3-left">
                <p style="font-family: Righteous; font-size: 20px">{{date('jS F, l, Y',strtotime(\Carbon\Carbon::today()))}}</p>
            </td>
            <td class="w3-right">
                <div id="DigitalCLOCK" style="padding-top: 68px;font-family: Righteous" class="clock w3-right" onload="showTime()"></div>
            </td>
        </tr>
    </table>
</div>

<script>
    function showTime(){
        var date = new Date();
        var h = date.getHours();
        var m = date.getMinutes();
        var s = date.getSeconds();
        var session = "AM";

        if(h == 0){
            h = 12;
        }

        if(h > 12){
            h = h - 12;
            session = "PM";
        }

        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("DigitalCLOCK").innerText = time ;
        document.getElementById("DigitalCLOCK").textContent = time;

        setTimeout(showTime, 1000);

    }

    showTime();

</script>
