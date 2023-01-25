function ge(o) 
{
	if (document.getElementById(o)!=null)
		return document.getElementById(o);
	else
		return false;
}

function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
var flag=false;
var resultat=[-1,'','']
var long_load=0;



function ZAPROS_AJAX(str,body,get_post)
{
	resultat=[-1,'',''];
	flag=false;
	var req = getXmlHttp();
	req.onreadystatechange = function() 
	{
		if (req.readyState == 4) { 
			if(req.status == 200) 
			{
				{
					
					s=req.responseText;
					temp = s.split('||---||');
					if (temp[0]==1)
						{
							tt='';
							if (temp[2]!=undefined)
								tt=temp[2];
							resultat=[1, temp[1], tt];
							flag=true;
						}
					else
						if (temp[0]==2)
						{
							resultat=[2, temp[1],''];
							flag=true;
						}
					else
						if (temp[0]==3)
						{
							resultat=[3, temp[1],''];
							flag=true;
						}
					else
						{
							/*console.log(s);*/
							resultat=[0, 'Error',''];
							flag=true;
						}
				}
			}
			else
			{
				resultat=[0, 'Error not load'];
				flag=true;
			}
		}
	}
	if (get_post=='GET')
	{
		try
		{
			req.open('GET', str+'?'+body, true); // потом добавить больше параметров...
			req.send(null);
		}
		catch 
		{
			
			resultat=[0, 'Error 0',''];
			flag=true;//Ошибка...
		}
	}
	else
	{
		// Тут пост запрос
		req.open('POST', str, true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.setRequestHeader("Accept-Language", "ru, en");
		req.setRequestHeader("Accept-Charset", "utf-8");
		req.send(body);
	}
}




const waitUntil = (condition) => {
    return new Promise((resolve) => {
        let interval = setInterval(() => {
            if (!condition()) {
            	//console.log('Ждем ...'+long_load);
            	long_load++;
            	if (long_load>=50) // через 5 секунд считаем ошибкой
            		{
            			flag=true;
            			resultat=[0, 'Error long load',''];
            		}
                return
            }
            clearInterval(interval)
            resolve()
        }, 100)
    })
}


async function show_kategor_form(mouse=false)
{
	if (!mouse)
		ge('podskazki').style.display='block';
	else
		{
			if (ge('podskazki').style.display=='block')
				ge('podskazki').style.display='none'
			else
				ge('podskazki').style.display='block';
		}
	
	ge('podskazki').innerHTML="<img src='img/loading.gif' class='loading'>";
	// Теперь ajax подгружаем нужные категории...
	val=ge('find_cat').value;
	setTimeout(ZAPROS_AJAX,10,'ajax/kategor_form.php','val='+val,"GET");
	long_load=0;
	await waitUntil(() => flag);
	if (resultat[0]==1)
		{
			ge('podskazki').innerHTML=temp[1];
		}
}

var now_filtr='';
var id_filtr=0;


async function del_cat(val,id_filtr)
{
	now_filtr=now_filtr.replace('|'+val, '');
	ge("filtr_"+id_filtr).remove();
	setTimeout(ZAPROS_AJAX,10,'ajax/canvas_project.php','filtr='+now_filtr,"POST");
	long_load=0;
	await waitUntil(() => flag);
	if (resultat[0]==1)
		{
			ge('main_tbl').innerHTML=temp[1];
			ge('kol_proj').innerHTML=temp[2];
			
			ge('frame1').src='frame/chart.php?data='+temp[3];
		}
}

async function add_filtr()
{
if (ge('find_cat').value=='') {ge('podskazki').style.display='none';return false; };
	val=ge('find_cat').value;
	
	now_filtr_arr=now_filtr.split('|');
	if (now_filtr_arr.includes(val))
	{
		// Уже есть в фильтре...
		ge('find_cat').value='';
	}
	else
	{
		ge('podskazki').style.display='none';
		id_filtr++;
		ge('vibrani_kategor').innerHTML+="<div class='categor_vibrana' id='filtr_"+id_filtr+"'><div class='del_cat' onclick=\"del_cat('"+val+"',"+id_filtr+")\">×</div>"+val+"</div>";
		ge('find_cat').value='';
		now_filtr+="|"+val;
		// Обновляем общее кол-во проектов...
		// Обновляем главную форму...
		setTimeout(ZAPROS_AJAX,10,'ajax/canvas_project.php','filtr='+now_filtr,"POST");
		long_load=0;
		await waitUntil(() => flag);
		if (resultat[0]==1)
			{
				ge('main_tbl').innerHTML=temp[1];
				ge('kol_proj').innerHTML=temp[2];
				
				//alert('frame/chart.php?data='+temp[3]);
				ge('frame1').src='frame/chart.php?data='+temp[3];
				
			}
	}
}

