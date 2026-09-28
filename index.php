<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#edf3ed">
    <title>ฟ้าทั่วไทย | พยากรณ์อากาศ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --ink: #17352d;
            --muted: #71827a;
            --line: #e5ebe5;
            --paper: #ffffff;
            --canvas: #edf3ed;
            --green: #1b493c;
            --green-light: #d9e7da;
            --lime: #d6f078;
            --coral: #f2835d;
            --blue: #8bb8c3;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--canvas);
            color: var(--ink);
            font-family: "IBM Plex Sans Thai", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        button, select { font: inherit; }

        .shell { width: min(1120px, calc(100% - 48px)); margin: 0 auto; }

        .topbar {
            height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(23, 53, 45, .1);
        }

        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-mark {
            width: 38px; height: 38px; display: grid; place-items: center;
            border-radius: 12px; background: var(--green); color: var(--lime); font-size: 22px;
        }
        .brand-name { font-size: 17px; font-weight: 700; letter-spacing: 0; }
        .brand-caption { color: var(--muted); font-size: 11px; margin-top: -3px; }
        .top-date { color: var(--muted); font-size: 13px; }

        main { padding: 34px 0 52px; }
        .page-heading { display: flex; justify-content: space-between; align-items: end; margin-bottom: 20px; gap: 20px; }
        h1 { font-size: 23px; line-height: 1.35; margin: 0; font-weight: 600; }
        .subtitle { margin: 3px 0 0; color: var(--muted); font-size: 13px; }

        .location-control {
            display: flex; align-items: center; gap: 9px; padding: 7px 10px 7px 13px;
            border: 1px solid #dce5dc; border-radius: 8px; background: var(--paper);
        }
        .location-control label { color: var(--muted); font-size: 12px; white-space: nowrap; }
        .location-control select {
            min-width: 112px; border: 0; outline: 0; color: var(--ink); font-weight: 600;
            background: transparent; cursor: pointer;
        }
        .refresh {
            width: 38px; height: 38px; display: grid; place-items: center; border: 1px solid #dce5dc;
            border-radius: 8px; background: var(--paper); color: var(--green); font-size: 21px; cursor: pointer;
        }
        .refresh:hover { background: var(--green-light); }

        .dashboard { display: grid; grid-template-columns: minmax(0, 1.55fr) minmax(280px, .85fr); gap: 16px; }
        .current-card {
            min-height: 290px; position: relative; overflow: hidden; padding: 27px 30px;
            border-radius: 10px; background: var(--green); color: white;
        }
        .current-card::before {
            content: ""; position: absolute; width: 280px; height: 280px; right: -35px; top: -104px;
            border: 1px solid rgba(214, 240, 120, .18); border-radius: 50%;
            box-shadow: 0 0 0 34px rgba(214, 240, 120, .035), 0 0 0 72px rgba(214, 240, 120, .025);
        }
        .current-top { position: relative; display: flex; justify-content: space-between; align-items: start; gap: 12px; }
        .eyebrow { color: #c3d1c7; font-size: 12px; }
        .city-name { margin-top: 4px; font-size: 21px; font-weight: 600; }
        .condition-pill { padding: 5px 10px; color: var(--lime); background: rgba(214, 240, 120, .1); border-radius: 999px; font-size: 11px; }
        .current-reading { position: relative; display: flex; align-items: center; gap: 18px; margin-top: 22px; }
        .weather-icon { color: var(--lime); font-size: 57px; line-height: 1; width: 66px; text-align: center; }
        .temperature { font-size: 76px; line-height: .95; font-weight: 500; letter-spacing: 0; }
        .degree { font-size: 37px; vertical-align: top; margin-left: 2px; }
        .condition-text { margin-top: 7px; color: #d1ddd4; font-size: 14px; }
        .feels-like { margin-top: 2px; color: #b3c2b8; font-size: 12px; }
        .high-low { position: absolute; right: 4px; bottom: 7px; color: #d1ddd4; font-size: 13px; text-align: right; }
        .high-low strong { color: white; font-weight: 500; }
        .current-foot { position: absolute; left: 30px; right: 30px; bottom: 18px; display: flex; justify-content: space-between; color: #b3c2b8; font-size: 11px; }

        .metrics { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .metric {
            min-height: 138px; padding: 17px 18px; display: flex; flex-direction: column; justify-content: space-between;
            border: 1px solid var(--line); border-radius: 9px; background: var(--paper);
        }
        .metric-label { color: var(--muted); font-size: 12px; display: flex; align-items: center; gap: 7px; }
        .metric-symbol { color: var(--coral); font-size: 15px; }
        .metric-value { font-size: 25px; font-weight: 600; line-height: 1.1; }
        .metric-unit { font-size: 13px; font-weight: 400; color: var(--muted); }
        .metric-note { color: var(--muted); font-size: 11px; }

        .lower-grid { display: grid; grid-template-columns: minmax(0, 1.55fr) minmax(280px, .85fr); gap: 16px; margin-top: 16px; }
        .panel { padding: 21px 23px; background: var(--paper); border: 1px solid var(--line); border-radius: 9px; }
        .panel-heading { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 17px; }
        h2 { margin: 0; font-size: 15px; font-weight: 600; }
        .panel-note { color: var(--muted); font-size: 11px; }
        .hourly-list { display: grid; grid-template-columns: repeat(7, minmax(50px, 1fr)); gap: 5px; }
        .hour { text-align: center; padding: 9px 2px 8px; border-radius: 7px; }
        .hour:first-child { background: #f0f5ef; }
        .hour-time { color: var(--muted); font-size: 11px; }
        .hour-icon { font-size: 20px; line-height: 1; margin: 12px 0 10px; color: var(--coral); }
        .hour-temp { font-size: 14px; font-weight: 600; }
        .hour-rain { display: block; min-height: 16px; margin-top: 3px; color: #5c99a7; font-size: 10px; }

        .forecast-list { display: flex; flex-direction: column; }
        .forecast-row { min-height: 39px; display: grid; grid-template-columns: 1fr 30px 42px 66px; align-items: center; gap: 6px; border-top: 1px solid #eef1ed; font-size: 12px; }
        .forecast-row:first-child { border-top: 0; }
        .forecast-day { color: var(--ink); }
        .forecast-icon { color: var(--coral); font-size: 17px; text-align: center; }
        .forecast-rain { color: #5c99a7; font-size: 10px; text-align: center; }
        .forecast-temps { text-align: right; white-space: nowrap; }
        .forecast-temps span { color: #93a098; margin-left: 5px; }
        .error-message { display: none; margin-top: 14px; padding: 11px 14px; border-radius: 7px; background: #fff0e8; color: #91432b; font-size: 12px; }
        .error-message.visible { display: block; }
        .loading { opacity: .6; }
        footer { padding-top: 18px; color: var(--muted); font-size: 11px; text-align: right; }
        footer a { color: var(--green); text-decoration-color: #a6b9aa; }

        @media (max-width: 760px) {
            .shell { width: min(100% - 30px, 560px); }
            .topbar { height: 70px; }
            .top-date { max-width: 130px; text-align: right; font-size: 11px; }
            main { padding-top: 25px; }
            .page-heading { align-items: start; flex-direction: column; margin-bottom: 15px; }
            h1 { font-size: 21px; }
            .dashboard, .lower-grid { grid-template-columns: 1fr; gap: 12px; }
            .current-card { min-height: 272px; padding: 23px; }
            .current-foot { left: 23px; right: 23px; }
            .metrics { gap: 9px; }
            .metric { min-height: 116px; padding: 14px; }
            .panel { padding: 18px 15px; }
            .hourly-list { grid-template-columns: repeat(7, minmax(42px, 1fr)); overflow-x: auto; }
            .hour { min-width: 42px; }
            footer { text-align: left; }
        }

        @media (max-width: 380px) {
            .shell { width: calc(100% - 22px); }
            .current-card { padding: 20px 17px; }
            .current-foot { left: 17px; right: 17px; }
            .temperature { font-size: 66px; }
            .high-low { right: 0; font-size: 11px; }
            .weather-icon { width: 55px; font-size: 49px; }
            .hourly-list { grid-template-columns: repeat(7, 44px); }
        }
    </style>
</head>
<body>
    <div class="shell">
        <header class="topbar">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">☼</div>
                <div>
                    <div class="brand-name">ฟ้าทั่วไทย</div>
                    <div class="brand-caption">อากาศวันนี้ เป็นอย่างไร</div>
                </div>
            </div>
            <div class="top-date" id="todayDate">กำลังตรวจสอบวันที่...</div>
        </header>

        <main>
            <div class="page-heading">
                <div>
                    <h1>สภาพอากาศ</h1>
                    <p class="subtitle">พยากรณ์อากาศทั่วประเทศไทย</p>
                </div>
                <div style="display:flex; gap:8px; align-items:center">
                    <div class="location-control">
                        <label for="citySelect">จังหวัด</label>
                        <select id="citySelect" aria-label="เลือกจังหวัด"></select>
                    </div>
                    <button class="refresh" id="refreshButton" type="button" aria-label="โหลดข้อมูลอากาศใหม่" title="โหลดข้อมูลใหม่">↻</button>
                </div>
            </div>

            <section class="dashboard" id="weatherContent" aria-live="polite">
                <article class="current-card">
                    <div class="current-top">
                        <div>
                            <div class="eyebrow">สภาพอากาศขณะนี้</div>
                            <div class="city-name" id="cityName">กรุงเทพมหานคร</div>
                        </div>
                        <span class="condition-pill" id="currentBadge">กำลังโหลด</span>
                    </div>
                    <div class="current-reading">
                        <div class="weather-icon" id="currentIcon" aria-hidden="true">☼</div>
                        <div>
                            <div class="temperature"><span id="currentTemp">--</span><span class="degree">°</span></div>
                            <div class="condition-text" id="currentCondition">กำลังดึงข้อมูล...</div>
                            <div class="feels-like">รู้สึกเหมือน <span id="feelsLike">--</span>°</div>
                        </div>
                        <div class="high-low">สูงสุด <strong id="highTemp">--°</strong><br>ต่ำสุด <strong id="lowTemp">--°</strong></div>
                    </div>
                    <div class="current-foot"><span id="localTime">เวลาท้องถิ่น --:--</span><span id="updatedAt">ข้อมูลจากพยากรณ์อากาศ</span></div>
                </article>

                <div class="metrics" aria-label="รายละเอียดสภาพอากาศ">
                    <article class="metric">
                        <div class="metric-label"><span class="metric-symbol" aria-hidden="true">◌</span>ความชื้น</div>
                        <div class="metric-value"><span id="humidity">--</span><span class="metric-unit"> %</span></div>
                        <div class="metric-note">ความชื้นสัมพัทธ์</div>
                    </article>
                    <article class="metric">
                        <div class="metric-label"><span class="metric-symbol" aria-hidden="true">⌁</span>ความเร็วลม</div>
                        <div class="metric-value"><span id="windSpeed">--</span><span class="metric-unit"> กม./ชม.</span></div>
                        <div class="metric-note" id="windDirection">ทิศทางลม --</div>
                    </article>
                    <article class="metric">
                        <div class="metric-label"><span class="metric-symbol" aria-hidden="true">☂</span>โอกาสฝนวันนี้</div>
                        <div class="metric-value"><span id="rainChance">--</span><span class="metric-unit"> %</span></div>
                        <div class="metric-note">โอกาสเกิดฝนสูงสุด</div>
                    </article>
                    <article class="metric">
                        <div class="metric-label"><span class="metric-symbol" aria-hidden="true">☀</span>พระอาทิตย์ขึ้น</div>
                        <div class="metric-value" id="sunrise">--:--</div>
                        <div class="metric-note">พระอาทิตย์ตก <span id="sunset">--:--</span></div>
                    </article>
                </div>
            </section>

            <div class="error-message" id="errorMessage" role="status"></div>

            <section class="lower-grid" id="forecastContent">
                <article class="panel">
                    <div class="panel-heading">
                        <h2>พยากรณ์รายชั่วโมง</h2>
                        <span class="panel-note">ช่วง 7 ชั่วโมงถัดไป</span>
                    </div>
                    <div class="hourly-list" id="hourlyForecast">
                        <div class="hour"><div class="hour-time">--:--</div><div class="hour-icon">☼</div><div class="hour-temp">--°</div></div>
                    </div>
                </article>
                <article class="panel">
                    <div class="panel-heading">
                        <h2>พยากรณ์ 7 วัน</h2>
                        <span class="panel-note">อุณหภูมิ / โอกาสฝน</span>
                    </div>
                    <div class="forecast-list" id="dailyForecast"></div>
                </article>
            </section>

            <footer>ข้อมูลพยากรณ์จาก <a href="https://open-meteo.com/" target="_blank" rel="noreferrer">Open-Meteo</a></footer>
        </main>
    </div>

    <script>
        const cities = {
            bangkok: { name: "กรุงเทพมหานคร", lat: 13.7563, lon: 100.5018 },
            chiangmai: { name: "เชียงใหม่", lat: 18.7883, lon: 98.9853 },
            phuket: { name: "ภูเก็ต", lat: 7.8804, lon: 98.3923 },
            khonkaen: { name: "ขอนแก่น", lat: 16.4419, lon: 102.8350 },
            nakhon: { name: "นครราชสีมา", lat: 14.9799, lon: 102.0978 },
            chonburi: { name: "ชลบุรี", lat: 13.3611, lon: 100.9847 },
            songkhla: { name: "สงขลา", lat: 7.1897, lon: 100.5954 },
            chiangrai: { name: "เชียงราย", lat: 19.9105, lon: 99.8406 },
            ayutthaya: { name: "พระนครศรีอยุธยา", lat: 14.3532, lon: 100.5689 },
            surat: { name: "สุราษฎร์ธานี", lat: 9.1382, lon: 99.3217 }
        };

        const citySelect = document.getElementById("citySelect");
        const errorMessage = document.getElementById("errorMessage");
        const weatherContent = document.getElementById("weatherContent");
        const forecastContent = document.getElementById("forecastContent");
        const dateFormatter = new Intl.DateTimeFormat("th-TH", {
            timeZone: "Asia/Bangkok", weekday: "long", day: "numeric", month: "long", year: "numeric"
        });
        const shortDayFormatter = new Intl.DateTimeFormat("th-TH", {
            timeZone: "Asia/Bangkok", weekday: "short", day: "numeric", month: "short"
        });

        Object.entries(cities).forEach(([key, city]) => {
            const option = document.createElement("option");
            option.value = key;
            option.textContent = city.name;
            citySelect.appendChild(option);
        });

        function weatherFor(code, isDay = true) {
            if (code === 0) return { label: "ท้องฟ้าแจ่มใส", icon: isDay ? "☀" : "☾" };
            if (code === 1) return { label: "แดดออกเป็นส่วนใหญ่", icon: "🌤" };
            if (code === 2) return { label: "มีเมฆบางส่วน", icon: "⛅" };
            if (code === 3) return { label: "เมฆมาก", icon: "☁" };
            if ([45, 48].includes(code)) return { label: "มีหมอก", icon: "〰" };
            if ([51, 53, 55, 56, 57].includes(code)) return { label: "ฝนปรอย", icon: "🌦" };
            if ([61, 63, 65, 66, 67, 80, 81, 82].includes(code)) return { label: "ฝนตก", icon: "🌧" };
            if ([71, 73, 75, 77, 85, 86].includes(code)) return { label: "หิมะตก", icon: "❄" };
            if ([95, 96, 99].includes(code)) return { label: "พายุฝนฟ้าคะนอง", icon: "⛈" };
            return { label: "สภาพอากาศทั่วไป", icon: "☁" };
        }

        function localClock(value) {
            return new Intl.DateTimeFormat("th-TH", {
                timeZone: "Asia/Bangkok", hour: "2-digit", minute: "2-digit", hour12: false
            }).format(new Date(value));
        }

        function compass(degrees) {
            return ["เหนือ", "ตะวันออกเฉียงเหนือ", "ตะวันออก", "ตะวันออกเฉียงใต้", "ใต้", "ตะวันตกเฉียงใต้", "ตะวันตก", "ตะวันตกเฉียงเหนือ"][Math.round(degrees / 45) % 8];
        }

        function renderWeather(data) {
            const current = data.current;
            const today = data.daily;
            const condition = weatherFor(current.weather_code, current.is_day);
            document.getElementById("currentIcon").textContent = condition.icon;
            document.getElementById("currentTemp").textContent = Math.round(current.temperature_2m);
            document.getElementById("currentCondition").textContent = condition.label;
            document.getElementById("currentBadge").textContent = current.is_day ? "กลางวัน" : "กลางคืน";
            document.getElementById("feelsLike").textContent = Math.round(current.apparent_temperature);
            document.getElementById("highTemp").textContent = `${Math.round(today.temperature_2m_max[0])}°`;
            document.getElementById("lowTemp").textContent = `${Math.round(today.temperature_2m_min[0])}°`;
            document.getElementById("humidity").textContent = Math.round(current.relative_humidity_2m);
            document.getElementById("windSpeed").textContent = Math.round(current.wind_speed_10m);
            document.getElementById("windDirection").textContent = `ลม${compass(current.wind_direction_10m)}`;
            document.getElementById("rainChance").textContent = Math.round(today.precipitation_probability_max[0] ?? 0);
            document.getElementById("sunrise").textContent = localClock(today.sunrise[0]);
            document.getElementById("sunset").textContent = localClock(today.sunset[0]);
            document.getElementById("localTime").textContent = `เวลาท้องถิ่น ${localClock(current.time)} น.`;
            document.getElementById("todayDate").textContent = dateFormatter.format(new Date(current.time));
            document.getElementById("updatedAt").textContent = `อัปเดต ${localClock(new Date())} น.`;

            const startIndex = Math.max(0, data.hourly.time.findIndex(time => time >= current.time));
            document.getElementById("hourlyForecast").innerHTML = data.hourly.time.slice(startIndex, startIndex + 7).map((time, offset) => {
                const index = startIndex + offset;
                const weather = weatherFor(data.hourly.weather_code[index], true);
                const rain = data.hourly.precipitation_probability[index];
                return `<div class="hour"><div class="hour-time">${localClock(time)}</div><div class="hour-icon" aria-label="${weather.label}">${weather.icon}</div><div class="hour-temp">${Math.round(data.hourly.temperature_2m[index])}°</div><span class="hour-rain">${rain ? `${Math.round(rain)}%` : ""}</span></div>`;
            }).join("");

            document.getElementById("dailyForecast").innerHTML = today.time.map((date, index) => {
                const weather = weatherFor(today.weather_code[index]);
                const label = index === 0 ? "วันนี้" : shortDayFormatter.format(new Date(`${date}T12:00:00+07:00`));
                const rain = Math.round(today.precipitation_probability_max[index] ?? 0);
                return `<div class="forecast-row"><span class="forecast-day">${label}</span><span class="forecast-icon" aria-label="${weather.label}">${weather.icon}</span><span class="forecast-rain">${rain ? `${rain}%` : ""}</span><span class="forecast-temps">${Math.round(today.temperature_2m_max[index])}°<span>${Math.round(today.temperature_2m_min[index])}°</span></span></div>`;
            }).join("");
        }

        async function loadWeather() {
            const city = cities[citySelect.value];
            document.getElementById("cityName").textContent = city.name;
            errorMessage.classList.remove("visible");
            weatherContent.classList.add("loading");
            forecastContent.classList.add("loading");

            const params = new URLSearchParams({
                latitude: city.lat,
                longitude: city.lon,
                current: "temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,weather_code,wind_speed_10m,wind_direction_10m",
                hourly: "temperature_2m,precipitation_probability,weather_code",
                daily: "weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,precipitation_probability_max",
                timezone: "Asia/Bangkok",
                forecast_days: "7",
                wind_speed_unit: "kmh"
            });

            try {
                const response = await fetch(`https://api.open-meteo.com/v1/forecast?${params}`);
                if (!response.ok) throw new Error("weather request failed");
                renderWeather(await response.json());
            } catch (error) {
                errorMessage.textContent = "โหลดข้อมูลไม่สำเร็จ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ตแล้วลองใหม่อีกครั้ง";
                errorMessage.classList.add("visible");
            } finally {
                weatherContent.classList.remove("loading");
                forecastContent.classList.remove("loading");
            }
        }

        citySelect.addEventListener("change", loadWeather);
        document.getElementById("refreshButton").addEventListener("click", loadWeather);
        loadWeather();
    </script>
</body>
</html>