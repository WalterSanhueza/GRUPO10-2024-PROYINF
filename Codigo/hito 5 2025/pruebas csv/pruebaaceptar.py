cantidad = 73
nombre_archivo = "ids.csv"

with open(nombre_archivo, "w", encoding="utf-8") as archivo:
    for i in range(118, cantidad + 118):

        linea = f"{i}"

        if i < cantidad:
            archivo.write(linea + ",\n")
        else:
            archivo.write(linea + "\n")  # Cierra la consulta con punto y coma

print(f"Archivo '{nombre_archivo}' generado con {cantidad} usuarios.")
