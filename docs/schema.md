Database schema
===============

The database schema is relatively simple. It _can_ be a little awkward in
places because of the source and field information being retained in classes
and not cached in the database, but there's no need yet. Hopefully we can get
core to implement subplugins for report plugins. ;-)

```awe_reports```
-----------------

The reports table stores metadata about the reports themselves.

| Field      | Description      |
| ---------- | ---------------- |
| ```id```   | ID of the report |
| ```name``` | Report title     |

```awe_sources```
-----------------

The sources table stores relationships between reports and tables involved in their generation.

| Field          | Description                                                          |
| -------------- | -------------------------------------------------------------------- |
| ```id```       | ID of the source                                                     |
| ```reportid``` | ID of the report record                                              |
| ```source```   | Name of the source                                                   |
| ```primary```  | Whether or not the source is the primary source for the report query |

```awe_fields```
----------------

The fields table tracks the fields to be displayed as part of a report.

| Field          | Description                         |
| -------------- | ----------------------------------- |
| ```id```       | ID of the field                     |
| ```sourceid``` | ID of the source record             |
| ```field```    | Name of the field in the source     |
| ```display```  | Whether or not to display the field |
