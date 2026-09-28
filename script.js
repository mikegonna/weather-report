const provinces = [
    ["กรุงเทพมหานคร", "Bangkok"],
    ["กระบี่", "Krabi"],
    ["กาญจนบุรี", "Kanchanaburi"],
    ["กาฬสินธุ์", "Kalasin"],
    ["กำแพงเพชร", "Kamphaeng Phet"],
    ["ขอนแก่น", "Khon Kaen"],
    ["จันทบุรี", "Chanthaburi"],
    ["ฉะเชิงเทรา", "Chachoengsao"],
    ["ชลบุรี", "Chon Buri"],
    ["ชัยนาท", "Chai Nat"],
    ["ชัยภูมิ", "Chaiyaphum"],
    ["ชุมพร", "Chumphon"],
    ["เชียงราย", "Chiang Rai"],
    ["เชียงใหม่", "Chiang Mai"],
    ["ตรัง", "Trang"],
    ["ตราด", "Trat"],
    ["ตาก", "Tak"],
    ["นครนายก", "Nakhon Nayok"],
    ["นครปฐม", "Nakhon Pathom"],
    ["นครพนม", "Nakhon Phanom"],
    ["นครราชสีมา", "Nakhon Ratchasima"],
    ["นครศรีธรรมราช", "Nakhon Si Thammarat"],
    ["นครสวรรค์", "Nakhon Sawan"],
    ["นนทบุรี", "Nonthaburi"],
    ["นราธิวาส", "Narathiwat"],
    ["น่าน", "Nan"],
    ["บึงกาฬ", "Bueng Kan"],
    ["บุรีรัมย์", "Buri Ram"],
    ["ปทุมธานี", "Pathum Thani"],
    ["ประจวบคีรีขันธ์", "Prachuap Khiri Khan"],
    ["ปราจีนบุรี", "Prachin Buri"],
    ["ปัตตานี", "Pattani"],
    ["พระนครศรีอยุธยา", "Phra Nakhon Si Ayutthaya"],
    ["พะเยา", "Phayao"],
    ["พังงา", "Phang Nga"],
    ["พิจิตร", "Phichit"],
    ["พิษณุโลก", "Phitsanulok"],
    ["เพชรบุรี", "Phetchaburi"],
    ["เพชรบูรณ์", "Phetchabun"],
    ["แพร่", "Phrae"],
    ["พัทลุง", "Phatthalung"],
    ["ภูเก็ต", "Phuket"],
    ["มหาสารคาม", "Maha Sarakham"],
    ["มุกดาหาร", "Mukdahan"],
    ["แม่ฮ่องสอน", "Mae Hong Son"],
    ["ยโสธร", "Yasothon"],
    ["ยะลา", "Yala"],
    ["ร้อยเอ็ด", "Roi Et"],
    ["ระนอง", "Ranong"],
    ["ระยอง", "Rayong"],
    ["ราชบุรี", "Ratchaburi"],
    ["ลพบุรี", "Lop Buri"],
    ["ลำปาง", "Lampang"],
    ["ลำพูน", "Lamphun"],
    ["เลย", "Loei"],
    ["ศรีสะเกษ", "Si Sa Ket"],
    ["สกลนคร", "Sakon Nakhon"],
    ["สงขลา", "Songkhla"],
    ["สตูล", "Satun"],
    ["สมุทรปราการ", "Samut Prakan"],
    ["สมุทรสงคราม", "Samut Songkhram"],
    ["สมุทรสาคร", "Samut Sakhon"],
    ["สระแก้ว", "Sa Kaeo"],
    ["สระบุรี", "Saraburi"],
    ["สิงห์บุรี", "Sing Buri"],
    ["สุโขทัย", "Sukhothai"],
    ["สุพรรณบุรี", "Suphan Buri"],
    ["สุราษฎร์ธานี", "Surat Thani"],
    ["สุรินทร์", "Surin"],
    ["หนองคาย", "Nong Khai"],
    ["หนองบัวลำภู", "Nong Bua Lamphu"],
    ["อ่างทอง", "Ang Thong"],
    ["อำนาจเจริญ", "Amnat Charoen"],
    ["อุดรธานี", "Udon Thani"],
    ["อุตรดิตถ์", "Uttaradit"],
    ["อุทัยธานี", "Uthai Thani"],
    ["อุบลราชธานี", "Ubon Ratchathani"]
];
const locationCache = new Map();

const provinceSearch = document.getElementById("provinceSearch");
const provinceOptions = document.getElementById("provinceOptions");
let selectedProvinceIndex = 0;
let gpsLocation = null;
const errorMessage = document.getElementById("errorMessage");
const weatherContent = document.getElementById("weatherContent");
const forecastContent = document.getElementById("forecastContent");
const locationStatus = document.getElementById("locationStatus");
const dateFormatter = new Intl.DateTimeFormat("th-TH", {
    timeZone: "Asia/Bangkok", weekday: "long", day: "numeric", month: "long", year: "numeric"
});
const shortDayFormatter = new Intl.DateTimeFormat("th-TH", {
    timeZone: "Asia/Bangkok", weekday: "short", day: "numeric", month: "short"
});

provinces.forEach(([name]) => {
    const suggestion = document.createElement("option");
    suggestion.value = name;
    provinceOptions.appendChild(suggestion);
});
provinceSearch.value = provinces[selectedProvinceIndex][0];

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
    const [provinceName, searchName] = provinces[selectedProvinceIndex];
    document.getElementById("cityName").textContent = gpsLocation?.displayName ?? provinceName;
    errorMessage.classList.remove("visible");
    weatherContent.classList.add("loading");
    forecastContent.classList.add("loading");

    try {
        let location = gpsLocation ?? locationCache.get(searchName);
        if (!location) {
            const geocodingParams = new URLSearchParams({
                name: searchName,
                count: "10",
                language: "en",
                format: "json",
                countryCode: "TH"
            });
            const geocodingResponse = await fetch(`https://geocoding-api.open-meteo.com/v1/search?${geocodingParams}`);
            if (!geocodingResponse.ok) throw new Error("location lookup failed");
            const geocodingData = await geocodingResponse.json();
            location = geocodingData.results?.find(result => result.country_code === "TH" && result.feature_code === "PPLA")
                ?? geocodingData.results?.find(result => result.country_code === "TH");
            if (!location) throw new Error("province location not found");
            locationCache.set(searchName, location);
        }

        const params = new URLSearchParams({
            latitude: location.latitude,
            longitude: location.longitude,
            current: "temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,weather_code,wind_speed_10m,wind_direction_10m",
            hourly: "temperature_2m,precipitation_probability,weather_code",
            daily: "weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,precipitation_probability_max",
            timezone: "Asia/Bangkok",
            forecast_days: "7",
            wind_speed_unit: "kmh"
        });
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

provinceSearch.addEventListener("input", () => provinceSearch.setCustomValidity(""));
provinceSearch.addEventListener("change", () => {
    const searchName = provinceSearch.value.trim();
    const provinceIndex = provinces.findIndex(([name]) => name === searchName);
    if (provinceIndex === -1) {
        provinceSearch.setCustomValidity("เลือกจังหวัดจากรายการ");
        provinceSearch.reportValidity();
        return;
    }

    provinceSearch.setCustomValidity("");
    gpsLocation = null;
    locationStatus.textContent = "";
    selectedProvinceIndex = provinceIndex;
    loadWeather();
});
document.getElementById("gpsButton").addEventListener("click", () => {
    if (!navigator.geolocation) {
        locationStatus.textContent = "เบราว์เซอร์นี้ไม่รองรับการระบุตำแหน่ง";
        return;
    }

    locationStatus.textContent = "กำลังขอตำแหน่งจากอุปกรณ์...";
    navigator.geolocation.getCurrentPosition(async ({ coords }) => {
        let reverseLocation = null;
        try {
            const reverseParams = new URLSearchParams({
                latitude: coords.latitude,
                longitude: coords.longitude,
                localityLanguage: "th"
            });
            const reverseResponse = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?${reverseParams}`);
            if (reverseResponse.ok) reverseLocation = await reverseResponse.json();
        } catch {
            // GPS weather still works when reverse geocoding is unavailable.
        }

        const subdivision = reverseLocation?.principalSubdivisionThai
            || reverseLocation?.principalSubdivision
            || "";
        const normalizedSubdivision = subdivision.replace(/^จังหวัด\s*/, "").trim();
        const matchedProvince = provinces.find(([thaiName, englishName]) =>
            thaiName === normalizedSubdivision || englishName.toLowerCase() === normalizedSubdivision.toLowerCase()
        );
        const provinceName = matchedProvince?.[0] || normalizedSubdivision || "ตำแหน่งปัจจุบัน";
        const locality = reverseLocation?.locality || reverseLocation?.city || provinceName;

        gpsLocation = {
            latitude: coords.latitude,
            longitude: coords.longitude,
            displayName: locality
        };
        if (matchedProvince) selectedProvinceIndex = provinces.indexOf(matchedProvince);
        provinceSearch.value = provinceName;
        provinceSearch.setCustomValidity("");
        locationStatus.textContent = `ใช้ตำแหน่ง GPS: ${provinceName}`;
        loadWeather();
    }, error => {
        const messages = {
            1: "ไม่ได้รับอนุญาตให้เข้าถึงตำแหน่ง",
            2: "ไม่สามารถระบุตำแหน่งอุปกรณ์ได้",
            3: "การขอตำแหน่งใช้เวลานานเกินไป"
        };
        locationStatus.textContent = `${messages[error.code] || "ระบุตำแหน่งไม่สำเร็จ"} กรุณาลองอีกครั้ง`;
    }, { enableHighAccuracy: false, timeout: 10000, maximumAge: 60000 });
});
document.getElementById("refreshButton").addEventListener("click", loadWeather);
loadWeather();