from graphviz import Digraph

# Create a graph for the ERD
dot = Digraph(format='pdf')

# Define Entities (Rectangles)
dot.node('Admin', 'Admin')
dot.node('Cars', 'Cars')
dot.node('Customers', 'Customers')
dot.node('Offices', 'Offices')
dot.node('Reservations', 'Reservations')

# Define Attributes (Ovals) and connect them to entities
dot.node('admin_id', 'admin_id')
dot.node('admin_first_name', 'first_name')
dot.node('admin_last_name', 'last_name')
dot.node('admin_email', 'email')
dot.node('admin_password', 'password')
dot.edge('Admin', 'admin_id', arrowhead='none')
dot.edge('Admin', 'admin_first_name', arrowhead='none')
dot.edge('Admin', 'admin_last_name', arrowhead='none')
dot.edge('Admin', 'admin_email', arrowhead='none')
dot.edge('Admin', 'admin_password', arrowhead='none')

dot.node('car_id', 'car_id')
dot.node('model', 'model')
dot.node('year', 'year')
dot.node('status', 'status')
dot.node('price_per_day', 'price_per_day')
dot.node('plate_id', 'plate_id')
dot.node('image', 'image')
dot.edge('Cars', 'car_id', arrowhead='none')
dot.edge('Cars', 'model', arrowhead='none')
dot.edge('Cars', 'year', arrowhead='none')
dot.edge('Cars', 'status', arrowhead='none')
dot.edge('Cars', 'price_per_day', arrowhead='none')
dot.edge('Cars', 'plate_id', arrowhead='none')
dot.edge('Cars', 'image', arrowhead='none')

dot.node('customer_id', 'customer_id')
dot.node('customer_first_name', 'first_name')
dot.node('customer_last_name', 'last_name')
dot.node('customer_email', 'email')
dot.node('phone_number', 'phone_number')
dot.node('customer_password', 'password')
dot.edge('Customers', 'customer_id', arrowhead='none')
dot.edge('Customers', 'customer_first_name', arrowhead='none')
dot.edge('Customers', 'customer_last_name', arrowhead='none')
dot.edge('Customers', 'customer_email', arrowhead='none')
dot.edge('Customers', 'phone_number', arrowhead='none')
dot.edge('Customers', 'customer_password', arrowhead='none')

dot.node('office_id', 'office_id')
dot.node('office_name', 'office_name')
dot.node('location', 'location')
dot.node('office_phone_number', 'phone_number')
dot.node('office_email', 'email')
dot.edge('Offices', 'office_id', arrowhead='none')
dot.edge('Offices', 'office_name', arrowhead='none')
dot.edge('Offices', 'location', arrowhead='none')
dot.edge('Offices', 'office_phone_number', arrowhead='none')
dot.edge('Offices', 'office_email', arrowhead='none')

dot.node('reservation_id', 'reservation_id')
dot.node('reservation_status', 'reservation_status')
dot.node('start_date', 'start_date')
dot.node('end_date', 'end_date')
dot.node('total_price', 'total_price')
dot.edge('Reservations', 'reservation_id', arrowhead='none')
dot.edge('Reservations', 'reservation_status', arrowhead='none')
dot.edge('Reservations', 'start_date', arrowhead='none')
dot.edge('Reservations', 'end_date', arrowhead='none')
dot.edge('Reservations', 'total_price', arrowhead='none')

# Define Relationships (Diamonds)
dot.node('Rel1', 'Has')
dot.node('Rel2', 'Rents')
dot.node('Rel3', 'Works At')
dot.node('Rel4', 'Located In')

# Admin - Has - Cars Relationship
dot.edge('Admin', 'Rel1', arrowhead='diamond')
dot.edge('Rel1', 'Cars', arrowhead='diamond')

# Customer - Rents - Cars Relationship
dot.edge('Customers', 'Rel2', arrowhead='diamond')
dot.edge('Rel2', 'Cars', arrowhead='diamond')

# Reservation - Works At - Offices Relationship
dot.edge('Reservations', 'Rel3', arrowhead='diamond')
dot.edge('Rel3', 'Offices', arrowhead='diamond')

# Car - Located In - Office Relationship
dot.edge('Cars', 'Rel4', arrowhead='diamond')
dot.edge('Rel4', 'Offices', arrowhead='diamond')

# Add Cardinality
dot.edge('Admin', 'Cars', label='1:N', arrowhead='none')
dot.edge('Customers', 'Reservations', label='1:N', arrowhead='none')
dot.edge('Cars', 'Reservations', label='1:N', arrowhead='none')
dot.edge('Offices', 'Cars', label='1:N', arrowhead='none')
dot.edge('Offices', 'Reservations', label='1:N', arrowhead='none')

# Save the ERD as a PDF
output_path = 'car_rental_system_erd_corrected'
dot.render(output_path)

output_path
