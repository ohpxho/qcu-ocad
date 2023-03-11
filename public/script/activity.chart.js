function renderCalenderActivityGraph(id, year, data=[]) {
  const daysOfYear = getArrayOfEveryDayOfYear(year);
  let html = `<svg width="900" height="128"><g transform="translate(20, 25)">`;

  let parentGTranslateXPosition = 0;
  
  html += `<g transform="translate(${parentGTranslateXPosition}, 0)">`;
  parentGTranslateXPosition += 16;

  let d = 0;
  while(d < daysOfYear.length) {
    const day = new Date(daysOfYear[d]).getDay();
    const dt = formatActionDate(daysOfYear[d]);

    const countOfActivity = getMapValue(data, dt);
    const fill = getEquivalentFillColorByValue(countOfActivity);
   
    html += `<rect width="11" fill="${fill}" height="11" x="16" y="${getTranslateYPostionOfDay(day)}" data-date="${dt}" data-level="0" rx="2" ry="2"><title>${dt} - ${countOfActivity} (no. of activity)</title></rect>`;
    
    if(day==6) {
      html += `</g><g transform="translate(${parentGTranslateXPosition}, 0)">` 
      parentGTranslateXPosition += 16;
    }

    d+=1;
  }
  
  html += '</g>';
  
  html+='<text x="16" y="-8" class="text-sm">Jan</text>';
  html+='<text x="91" y="-8" class="text-sm">Feb</text>';
  html+='<text x="151" y="-8" class="text-sm">Mar</text>';
  html+='<text x="226" y="-8" class="text-sm">Apr</text>';
  html+='<text x="286" y="-8" class="text-sm">May</text>';
  html+='<text x="361" y="-8" class="text-sm">Jun</text>';
  html+='<text x="440" y="-8" class="text-sm">Jul</text>';
  html+='<text x="500" y="-8" class="text-sm">Aug</text>';
  html+='<text x="560" y="-8" class="text-sm">Sep</text>';
  html+='<text x="640" y="-8" class="text-sm">Oct</text>';
  html+='<text x="710" y="-8" class="text-sm">Nov</text>';
  html+='<text x="770" y="-8" class="text-sm">Dec</text>';
  
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="8" style="display: none;">Sun</text>';
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="25" >Mon</text>';
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="32" style="display: none;">Tue</text>';
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="56" >Wed</text>';
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="57" style="display: none;">Thu</text>';
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="85" >Fri</text>';
  html+='<text text-anchor="start" class="text-sm" dx="-18" dy="81" style="display: none;">Sat</text>';

  html+='</g></svg>';
  
  $(`#${id}`).append(html);
}

function getFrequencyOfActivities(activities) {
  freq = new Map();

  for(activity of activities) {
    const dt = formatActionDate(activity['date_acted']);
    freq.set(dt, getMapValue(freq, dt)+1)
  }

  return freq;
}

function getMapValue(map, key) {
  return map.get(key) || 0;
}

function getEquivalentFillColorByValue(freq) {
  if(freq==0) return '#CBD5E1';
  else if(freq<2) return '#86EFAC';
  else if(freq<4) return '#4ADE80';
  else if(freq<5) return '#16A34A'
  else return '#166534'
}

function formatActionDate(dt) {
  const date = new Date(dt);
  return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear();
}

function getArrayOfEveryDayOfYear(year) {
  days = [];
  
  for (let d = new Date(year, 0, 1); d <= new Date(year, 11, 31); d.setDate(d.getDate() + 1)) {
    days.push(new Date(d));
  }

  return days;
}

function getTranslateYPostionOfDay(day) {
  return day*15;
}