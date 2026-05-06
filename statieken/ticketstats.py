@app.route("/ticketstats")
def ticketstats():
    cursor.execute("""
        SELECT datum, COUNT(*) as aantal
        FROM tb_tickets
        GROUP BY datum
        ORDER BY datum
    """)
    
    data = cursor.fetchall()
    return jsonify(data)