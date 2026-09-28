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
    <link rel="stylesheet" href="style.css">
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
                <div class="province-tools">
                    <label class="sr-only" for="provinceSearch">ค้นหาชื่อจังหวัด</label>
                    <input class="province-search" id="provinceSearch" type="search" list="provinceOptions" placeholder="ค้นหาชื่อจังหวัด" autocomplete="off">
                    <datalist id="provinceOptions"></datalist>
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

            <footer>ข้อมูลตำแหน่งและพยากรณ์จาก <a href="https://open-meteo.com/" target="_blank" rel="noreferrer">Open-Meteo</a></footer>
        </main>
    </div>

    <script src="script.js" defer></script>
</body>
</html>