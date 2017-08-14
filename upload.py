import requests
import sys
valortoken = sys.argv[1]
idMovimiento = sys.argv[2]
#hay que 
cabecera = {
'Accept':'*/*',
#'Referer':'http://www.egga.cl',
'Accept-Language':'es-cl',
#'Content-Type':'multipart/form-data: boundary=7d23e2a11301c4',
'Accept-Encoding':'gzip, deflate',
'User-Agent':'Mozilla/4.0 (compatible; PROG 1.0; Windows NT 5.0; YComp 5.0.2.4)',
#'Content-Length':'8653',
#'Connection':'Keep-Alive',
#'Cache-Control':'no-cache'

}
#archivo xml a cargar
archivo={'archivo': open('/home/appventa/public_html/DTE/EnvioDTEfirmado'+idMovimiento+'.xml','rb')}

#datos del post   
datos = {'rutCompany':'76040308','dvCompany':'3','rutSender':'13968481','dvSender':'8'}
 
#valor del token
cookie = {'TOKEN':valortoken}
conexion = requests.post('https://maullin.sii.cl/cgi_dte/UPL/DTEUpload',verify=False,headers=cabecera,data=datos,files=archivo,cookies=cookie)	
#obtengo respuesta del envio en xml
respuesta = open("respuestaenvio"+idMovimiento+".xml","w")
respuesta.write(conexion.content)
respuesta.close
