const calendar = document.getElementById('calendar')
const monthYear = document.getElementById('currentMonthYear')
const previousMonth = document.getElementById('prevMonthBtn')
const nexMonth = document.getElementById('nextMonthBtn')

let currentMonth = 6
let currentYear = 2023

const generateCal = (month, year, lang, holidays = null) => {
    let calendarHTML = ''
    let headers = []

    if (lang === 'en') {
        headers = ['M', 'T', 'W', 'T', 'F', 'S', 'S']
    } else if (lang === 'es') {
        headers = ['L', 'M', 'M', 'J', 'V', 'S', 'D']
    } else if (lang === 'ca') {
        headers = ['DI', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds', 'Dg']
    }

    calendarHTML += '<table cellpadding="0" cellspacing="0" class="calendar">'
    calendarHTML += '<tr class="calendar-row"><td class="calendar-day-head">' + headers.join('</td><td class="calendar-day-head">') + '</td></tr>'

    let running_day = new Date(year, month - 1, 1).getDay()
    running_day = (running_day > 0) ? running_day - 1 : running_day
    let days_in_month = new Date(year, month, 0).getDate()
    let days_in_this_week = 1
    let day_counter = 0

    calendarHTML += '<tr class="calendar-row">'

    for (let x = 0; x < running_day; x++) {
        calendarHTML += '<td class="calendar-day-np"> </td>';
        days_in_this_week++
    }

    for (let list_day = 1; list_day <= days_in_month; list_day++) {
        calendarHTML += '<td class="calendar-day">'
        let class_name = 'day-number '

        if (running_day === 0 || running_day === 6) {
            class_name += 'not-work '
        }

        let key_month_day = 'month_' + month + '_day_' + list_day;

        if (holidays != null && Array.isArray(holidays)) {
            let month_key = holidays.indexOf(key_month_day)

            if (month_key !== -1) {
                class_name += 'not-work-holiday '
            }
        }

        calendarHTML += '<div class="' + class_name + '">' + list_day + '</div>'
        calendarHTML += '</td>'

        if (running_day === 6) {
            calendarHTML += '</tr>';
            if ((day_counter + 1) !== days_in_month) {
                calendarHTML += '<tr class="calendar-row">'
            }
            running_day = -1
            days_in_this_week = 0
        }

        days_in_this_week++
        running_day++
        day_counter++
    }

    if (days_in_this_week < 8) {
        for (let x = 1; x <= (8 - days_in_this_week); x++) {
            calendarHTML += '<td class="calendar-day-np"> </td>'
        }
    }

    calendarHTML += '</tr>'
    calendarHTML += '</table>'

    calendar.innerHTML = calendarHTML;
    monthYear.textContent = getMonthName(month) + ' ' + year;
}

const getMonthName = (month) => {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
    return monthNames[month - 1];
}

const prevMonth = () => {
    currentMonth--;
    if (currentMonth < 1) {
        currentMonth = 12;
        currentYear--;
    }

    generateCal(currentMonth, currentYear, 'en');
}

const nextMonth = () => {
    currentMonth++;
    if (currentMonth > 12) {
        currentMonth = 1;
        currentYear++;
    }

    generateCal(currentMonth, currentYear, 'en');
}

previousMonth.addEventListener('click', prevMonth);
nexMonth.addEventListener('click', nextMonth);

generateCal(currentMonth, currentYear, 'en');