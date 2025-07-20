from astrapy import DataAPIClient
import pandas as pd

token = "AstraCS:zCiywgbIXtyIBSvatqyLdqfP:3966f60636dec5b490f59d14277d9afad2547a6fb5c9309eb5d90f7336761466"
endpoint = "https://dec5c0ac-1638-4930-8745-d5794df3f521-us-east-2.apps.astra.datastax.com"

client = DataAPIClient(token)
db = client.get_database_by_api_endpoint(endpoint)

coleccion = db["notificaciones"]

documentos = coleccion.find({})

if documentos:
    df = pd.DataFrame(documentos)
    df.to_csv("notificaciones_exportadas.csv", index=False, encoding="utf-8")
    print("✅ Exportación completada: notificaciones_exportadas.csv")
else:
    print("⚠ No se encontraron documentos.")
