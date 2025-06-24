cantidad = 130
nombre_archivo = "cc.csv"

with open(nombre_archivo, "w", encoding="utf-8") as archivo:
    for i in range(1, cantidad + 1):
        email = f"user{i}@mail.cl"
        rut = f"11111111-1"
        usuario = f"user"
        clave = f"clave{i}"

        linea = f"{email}, {usuario}, {rut}, {clave}"

        if i < cantidad:
            archivo.write(linea + "\n")
        else:
            archivo.write(linea + "\n")  # Cierra la consulta con punto y coma

print(f"Archivo '{nombre_archivo}' generado con {cantidad} usuarios.")
