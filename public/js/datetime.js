var datetime_data = {
    strings: {
        months: {
            parental: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
            nominative: ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'],
            parental_short: ['янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сент', 'окт', 'ноя', 'дек'],
            nominative_short: ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сент', 'окт', 'ноя', 'дек'],
        },
        weekDays: {
            parental: ['понедельнику', 'вторнику', 'среде', 'четвергу', 'пятнице', 'субботе', 'воскресенью'],
            nominative: ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'],
            short: ['пон', 'вт', 'ср', 'чет', 'пят', 'суб', 'вс'],
        }
    }
}

Date.prototype.getWeek = function() {
        
    return (new Date()).format('W');

};

Date.prototype.getWeekType = function() {
        
    // TODO: Улучшить механизм определения типа недели. Подключить к 1 сентября этого(/прошлого) календарного года
    return (new Date()).getWeek() % 2 == 0;

};

var timeFmt = function(time) {
    return time < 10 ? "0" + time : time;
};

var fillClock = function(clock, datetime, interval = false) {
    clock.find('.days').html(timeFmt(datetime.getDate() - (interval ? 1 : 0)));
    clock.find('.hours').html(timeFmt(datetime.getHours()));
    clock.find('.minutes').html(timeFmt(datetime.getMinutes()));
    clock.find('.seconds').html(timeFmt(datetime.getSeconds()));
}

var fillDate = function(date, datetime) {
    // dateTime.getDate возвращает ДЕНЬ. Здесь getDay НЕ использовать!
    date.html(datetime.getDate() + " " + datetime_data.strings.months.parental[datetime.getMonth()] + " " + datetime.getFullYear())
}
var fillDateShort = function(date, datetime) {
    date.html(datetime.getDate() + " " + datetime_data.strings.months.parental_short[datetime.getMonth()] + " " + datetime.getFullYear())
}
var fillDateNumeric = function(date, datetime) {
    date.html(datetime.getDate() + "." + datetime.getMonth() + "." + datetime.getFullYear())
}

var parseDate = function(date) {

    // TODO: Сделать парсинг с автоопределением формата
    return new Date(date);

}