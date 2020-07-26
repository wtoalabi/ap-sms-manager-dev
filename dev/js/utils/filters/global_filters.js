import Vue from 'vue'

Vue.filter('shorten', function(value, length){
  return aps_globals._.truncate(value, { length });
});


Vue.filter('capitalize', function(string){
  return string.charAt(0).toUpperCase() + string.slice(1)
});

Vue.filter('separateKebab', function(string){
  let arrayfiedString = string.split("_");
  if(arrayfiedString.length > 1){
    return arrayfiedString.join(" ")
  }else{
    return string;
  }
});

Vue.filter('joinStrings', function(string){
  let arrayfiedString = string.split(" ");
  if(arrayfiedString.length > 1){
    return arrayfiedString.join("")
  }else{
    return string;
  }
});

Vue.filter('bytesToMB', function(value){
  return ((value / 1024) / 1000).toFixed(3) + " MB"
});

Vue.filter('truncateThousand', function(value){
  if(Number.parseInt(value) >=9999){
    return Math.floor(value/1000) + 'K'
  }
  return numberInThousand(value);
});

Vue.filter('numberInThousand', function(number){
  return numberInThousand(number)
});

Vue.filter('birthdayString', function(birthday){
  if(birthday){
    return `${monthsMap[birthday['month']]} ${birthday['day']}`
  }
});

Vue.filter('textAvatar', function(text){
  if(text){
    let avatar = "";
    let textArray = text.split(" ");
    textArray.forEach(text=>{
      avatar += text[0].toUpperCase();
    });
    return avatar;
  }
});

let monthsMap  = {
  1: "Jan",
  2: "Feb",
  3: "Mar",
  4: "Apr",
  5: "May",
  6: "Jun",
  7: "Jul",
  8: "Aug",
  9: "Sept",
  10: "Oct",
  11: "Nov",
  12: "Dec",
}
function numberInThousand(number) {
  return number.toLocaleString('en-NG',{minimumFractionDigits: 0});
}
