# appdte
LIBRERIAS DE FACTURACION ELECTRONICA (CHILE).

DESCRIPCION DE ARCHIVOS:

Requisitos: php 5.0, python 2.7 (puede modificarse para python 3.0) y java con itext.

Barcode.java /* Es la librera para generar el codigo de barra pdf417 */

ClassDte.php /* Genera un DTE en formato xml y lo firma. Puede modificarse el oriden de datos */

EnvioDTE.php /* Envuelve un DTE firmado en un EnvioDTE y lo firma    */

sign.py /* Código de python que genera un timbre electrónico del dte */

upload.py /* realiza un upload al sii */

Semilla.php /* Obtiene la Semilla del sii */

Token.php /* Obtiene un Token del sii */

LecturaCaf.php /* Se engarga de leer el caf extraido del sii y adjuntarlo al dte */

ImpresionDte.java /* Es simplemente un clase java que lee un iforme de jasperreport */
