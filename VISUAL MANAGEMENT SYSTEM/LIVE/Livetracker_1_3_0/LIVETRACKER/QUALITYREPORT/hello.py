from docx2pdf import convert
import sys
import os,re
import comtypes.client
print ('Number of arguments:', len(sys.argv), 'arguments.')
print ('Argument List:', str(sys.argv))
#var3 = sys.argv[0]
#var1 = sys.argv[1]
var1="CuneguinesN(1)"
#var2 = sys.argv[2]
#var4=var1+var2
#print(var4)
import sys
import os
wdFormatPDF = 17
#in_file = os.path.abspath(sys.argv[1])
#out_file = os.path.abspath(sys.argv[2])
file = r'C:\\xampp\\htdocs\\QLTYFILES\\57 (5).docx'
out_file=r'C:\\xampp\\htdocs\\QLTYFILES\\57 (5)'
in_file='.\57 (5).docx'
#out_file='57 (5)'
word = comtypes.client.CreateObject('Word.Application')
doc = word.Documents.Open(file)
doc.SaveAs(out_file, FileFormat=wdFormatPDF)
doc.Close()
word.Quit()
x='"'r"C:\\xampp\\htdocs\\QLTYFILES\\"+ var1 +".pdf "'"'
y='"'r"C:\\xampp\\htdocs\\QLTYFILES\\"+ var1 +".docx "'"'
x=r"C:\\xampp\\htdocs\\QLTYFILES\\"+ var1 +".pdf "
y=r"C:\\xampp\\htdocs\\QLTYFILES\\"+ var1 +".docx "
print(x)
print(y)
#convert("C:\xampp\htdocs\VISUAL MANAGEMENT SYSTEM\LIVE\Livetracker_1_3_0\LIVETRACKER\QUALITYREPORT\8D Report Template (7).docx")
#convert(y,x)
#convert("my_docx_folder/")
#print(convert("C:\\xampp\htdocs\\QLTYFILES\\"+var4, "C:\\xampp\\htdocs\\QLTYFILES\\"+var4+".pdf"))
#convert("input.docx")
#convert("input.docx", "output.pdf")
#convert("my_docx_folder/")
folder=r"C:\xampp\htdocs\QLTYFILES"
files=[os.path.join(i[0],j) for i in os.walk(folder)for j in i[-1]if j.endswith('docx')]
for docx_file in files:
       pdf_file=re.sub('docx','pdf',docx_file)
       if os.path.exists(pdf_file):
                print('Existing %s' %pdf_file)
                continue
       print('converting')
       convert(docx_file,pdf_file)
