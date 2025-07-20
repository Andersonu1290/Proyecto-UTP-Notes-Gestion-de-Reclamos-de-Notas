from flask import Flask, jsonify, request
from flask_cors import CORS
from astrapy import DataAPIClient

app = Flask(__name__)
CORS(app)

client = DataAPIClient("AstraCS:chyreyNXNnSfyDmxbFgAPLoM:b0bcd261b2a13da16123437f7e7a99ba1f89a36b1c41646e28702285dcfbf270")
db = client.get_database_by_api_endpoint("https://dec5c0ac-1638-4930-8745-d5794df3f521-us-east-2.apps.astra.datastax.com")
collection = db.get_collection("notificaciones")

@app.route("/notificaciones", methods=["GET"])
def obtener_notificaciones():
    usuario = request.args.get("usuario")
    limite = int(request.args.get("limite", 5))
    resultados = [doc for doc in collection.find() if doc.get("destinatario") == usuario]

    notificaciones = []
    for doc in resultados:
        notificaciones.append({
            "id": doc.get("_id"),
            "titulo": doc.get("titulo", ""),
            "mensaje": doc.get("mensaje", ""),
            "fecha_envio": doc.get("fecha_envio", ""),
            "estado": doc.get("estado", ""),
            "tipo": doc.get("tipo", ""),
            "canal": doc.get("canal", "")
        })

    notificaciones.sort(key=lambda x: x['fecha_envio'], reverse=True)
    return jsonify(notificaciones[:limite])

@app.route("/notificaciones/crear", methods=["POST"])
def crear_notificacion():
    try:
        data = request.get_json()
        if not data or 'mensaje' not in data or 'destinatario' not in data:
            return jsonify({"error": "Datos incompletos"}), 400

        result = collection.insert_one(data)

        return jsonify({
            "mensaje": "Notificación registrada correctamente",
            "id": result.inserted_id
        }), 201

    except Exception as e:
        print("❌ Error en /notificaciones/crear:", str(e))
        return jsonify({"error": "Error al registrar la notificación"}), 500

@app.route("/notificaciones/eliminar/<string:noti_id>", methods=["DELETE"])
def eliminar_notificacion(noti_id):
    try:
        result = collection.delete_one({"_id": noti_id})
        if result.deleted_count == 1:
            return jsonify({"mensaje": "Notificación eliminada correctamente"}), 200
        else:
            return jsonify({"error": "No se encontró la notificación"}), 404
    except Exception as e:
        print("❌ Error al eliminar notificación:", str(e))
        return jsonify({"error": "Error al eliminar la notificación"}), 500

if __name__ == "__main__":
    app.run(port=5000, debug=True)
