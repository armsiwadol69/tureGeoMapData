# tureGeoMapData
นำข้อมูลจาก SQL Database ขึ้นไปแสดงบน Google Geomap 

framework : bootstrap 5
PHP & SQL.


Data Visualization : GeoChart By Google.


การส่งและอ่านข้อมูล (MapController.php)
//['จังหวัด', 'สถาณะ'] (0 = ปกติ, 1 = NSA, 2 = SA)
['Provinces', 'Status'], <br>
['buogkan',0],

ข้อมูลที่ใหม่กว่าจะถูกใช้


ในจังหวัดที่ไม่มีการเปิด Ticket จะเป็นสีเขียว
และเมื่อมีการเปิด Ticket จะอ่านค่าใหม่สุด

ทดลองได้ที่ http://siwadol69.yongsue.com/mapGeoData/


#BUG2FIX
 [BUG] Bueng Kan can't be used, must use "TH-38" instead.
