from Crypto.PublicKey import RSA
from Crypto.Signature import PKCS1_v1_5
from Crypto.Hash import SHA
import base64
import sys
MovimientoId = sys.argv[1]
key = RSA.importKey(open("archivorsa"+MovimientoId+".pem").read())
archivo = open("timbre"+MovimientoId+".txt","r")
message = archivo.read()

h = SHA.new(message)
p = PKCS1_v1_5.new(key)
signature = p.sign(h)

archivofirmado = open('timbrefirmado'+MovimientoId+'.txt','w')
archivofirmado.write(base64.b64encode(signature))
archivofirmado.close()
print "TIMBRE ELECTRONICO GENERADO"
