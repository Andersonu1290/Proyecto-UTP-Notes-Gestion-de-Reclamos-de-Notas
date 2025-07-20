--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5
-- Dumped by pg_dump version 17.5

-- Started on 2025-07-19 12:16:34

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 218 (class 1259 OID 16398)
-- Name: cursos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cursos (
    id integer NOT NULL,
    codigo character varying(10) NOT NULL,
    nombre character varying(100) NOT NULL,
    descripcion text,
    creditos integer NOT NULL,
    ciclo integer NOT NULL,
    facultad character varying(100),
    modalidad character varying(50),
    estado character varying(20) DEFAULT 'activo'::character varying
);


ALTER TABLE public.cursos OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16397)
-- Name: cursos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cursos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cursos_id_seq OWNER TO postgres;

--
-- TOC entry 4909 (class 0 OID 0)
-- Dependencies: 217
-- Name: cursos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cursos_id_seq OWNED BY public.cursos.id;


--
-- TOC entry 220 (class 1259 OID 16419)
-- Name: notas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notas (
    id integer NOT NULL,
    estudiante_id integer NOT NULL,
    curso_id integer NOT NULL,
    nota numeric(5,2),
    tipo_evaluacion character varying(50),
    observacion text,
    fecha_registro date,
    registrado_por character varying(100),
    id_profesor integer,
    CONSTRAINT notas_nota_check CHECK (((nota >= (0)::numeric) AND (nota <= (100)::numeric)))
);


ALTER TABLE public.notas OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16418)
-- Name: notas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notas_id_seq OWNER TO postgres;

--
-- TOC entry 4910 (class 0 OID 0)
-- Dependencies: 219
-- Name: notas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notas_id_seq OWNED BY public.notas.id;


--
-- TOC entry 4747 (class 2604 OID 16401)
-- Name: cursos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cursos ALTER COLUMN id SET DEFAULT nextval('public.cursos_id_seq'::regclass);


--
-- TOC entry 4749 (class 2604 OID 16422)
-- Name: notas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notas ALTER COLUMN id SET DEFAULT nextval('public.notas_id_seq'::regclass);


--
-- TOC entry 4901 (class 0 OID 16398)
-- Dependencies: 218
-- Data for Name: cursos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cursos (id, codigo, nombre, descripcion, creditos, ciclo, facultad, modalidad, estado) FROM stdin;
1	MAT101	Matemáticas Básicas	Curso de álgebra, aritmética y lógica matemática	4	1	Ingeniería	Presencial	activo
2	FIS101	Física General	Conceptos fundamentales de la física clásica	3	1	Ingeniería	Presencial	activo
3	INF102	Fundamentos de Programación	Introducción a la programación estructurada	4	1	Ing. Sistemas	Virtual	activo
4	ADM202	Administración I	Teoría administrativa clásica y moderna	3	2	Administración	Presencial	activo
5	COM203	Comunicación Efectiva	Técnicas de redacción y comunicación oral	2	2	Ciencias Humanas	Presencial	activo
6	EST204	Estadística I	Probabilidad y estadística descriptiva	3	2	Ingeniería	Presencial	activo
7	ECO205	Economía General	Principios de micro y macroeconomía	3	2	Economía	Semipresencial	activo
8	DRE206	Derecho Empresarial	Fundamentos de derecho para los negocios	3	3	Administración	Virtual	activo
9	MAR301	Marketing I	Fundamentos del marketing y comportamiento del consumidor	3	3	Administración	Presencial	activo
10	FIS302	Física II	Ondas, electricidad y magnetismo	3	3	Ingeniería	Presencial	activo
11	MAT302	Matemáticas Avanzadas	Ecuaciones diferenciales y cálculo vectorial	4	3	Ingeniería	Presencial	activo
12	BD303	Base de Datos I	Modelo relacional, SQL y diseño de bases de datos	4	3	Ing. Sistemas	Virtual	activo
13	SIS304	Sistemas Operativos	Gestión de procesos, memoria y archivos	4	3	Ing. Sistemas	Presencial	activo
14	RED305	Redes I	Modelo OSI y TCP/IP, direccionamiento IP	3	4	Ing. Sistemas	Presencial	activo
15	CON306	Contabilidad General	Registro contable y estados financieros básicos	3	4	Administración	Presencial	activo
16	FIN401	Finanzas I	Análisis financiero básico y decisiones de inversión	3	4	Administración	Virtual	activo
17	PSI402	Psicología Organizacional	Conducta humana en entornos laborales	2	4	Ciencias Humanas	Presencial	activo
18	ETH403	Ética Profesional	Ética en el ejercicio profesional	2	4	General	Presencial	activo
19	PRO404	Programación Web	HTML, CSS, JavaScript y backend básico	4	5	Ing. Sistemas	Presencial	activo
20	SEG405	Seguridad Informática	Criptografía, hacking ético y firewalls	3	5	Ing. Sistemas	Virtual	activo
21	IA406	Inteligencia Artificial	Algoritmos de aprendizaje automático	4	5	Ing. Sistemas	Presencial	activo
22	BIO407	Biología Básica	Genética, evolución y ecología	2	1	Ciencias	Presencial	activo
23	QUI408	Química General	Estructura atómica y enlaces químicos	3	1	Ciencias	Presencial	activo
24	SOC409	Sociología	Estructuras sociales y análisis de la cultura	2	2	Ciencias Humanas	Presencial	activo
25	LOG410	Lógica y Argumentación	Pensamiento lógico formal	2	1	General	Presencial	activo
26	ADM411	Gestión de Proyectos	PMI, cronogramas y gestión de riesgos	3	5	Administración	Virtual	activo
27	SIS412	Arquitectura de Computadoras	Hardware, buses y ensamblador	3	4	Ing. Sistemas	Presencial	activo
28	SIS413	Ingeniería de Software	Ciclo de vida de software y metodologías ágiles	4	5	Ing. Sistemas	Presencial	activo
29	RED414	Redes II	Routing, switching y configuración de redes	3	5	Ing. Sistemas	Presencial	activo
30	TIC415	Transformación Digital	Tendencias en innovación tecnológica	3	6	General	Virtual	activo
\.


--
-- TOC entry 4903 (class 0 OID 16419)
-- Dependencies: 220
-- Data for Name: notas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notas (id, estudiante_id, curso_id, nota, tipo_evaluacion, observacion, fecha_registro, registrado_por, id_profesor) FROM stdin;
1	1	10	10.02	Parcial	Mejorar	2025-01-03	Dr. Sánchez	39
2	2	5	19.61	Final	Desempeño bajo	2025-01-05	Dra. Navarro	1
3	3	9	9.13	Parcial	Buen desempeño en el examen	2025-01-06	Dr. Sánchez	42
4	4	21	13.15	Parcial	Cumplió con todos los criterios	2025-01-08	Ing. Díaz	25
5	5	25	9.22	Final	Buen desempeño en el examen	2025-01-09	Dra. Rojas	39
6	6	8	12.89	Parcial	Recuperación aprobada	2025-01-15	Ing. Bravo	28
7	7	8	10.44	Parcial	Buena mejora	2025-01-21	Dr. Ramírez	26
8	8	22	11.13	Final	Buena mejora	2025-01-22	Dra. León	17
9	9	18	10.38	Sustitutorio	Examen perfecto	2025-02-03	Ing. Chávez	11
10	10	15	8.57	Parcial	Refuerze le fato 4pt	2025-02-07	Lic. Mendoza	47
11	11	11	10.69	Final	Buen desempeño en el examen	2025-02-09	Dra. León	25
12	12	10	17.91	Sustitutorio	Buen desempeño en el examen	2025-02-19	Ing. Bravo	13
13	13	30	11.24	Final	Recuperación aprobada	2025-02-22	Dra. Navarro	45
14	14	9	11.65	Parcial	Cumplió con todos los criterios	2025-02-26	Ing. Chávez	7
15	15	16	17.54	Parcial	Buena mejora	2025-02-27	Lic. Romero	21
16	16	6	18.29	Parcial	Buen desempeño en el examen	2025-02-28	Ing. Díaz	18
17	17	4	13.46	Sustitutorio	Cumplió con todos los criterios	2025-03-01	Ing. Bravo	4
18	18	11	19.69	Parcial	Buena mejora	2025-03-02	Lic. Huamán	44
19	19	14	18.84	Sustitutorio	Necesita reforzar	2025-03-05	Lic. Mendoza	13
20	20	29	12.16	Final	Desempeño bajo	2025-03-10	Dr. Torres	2
21	21	24	9.90	Sustitutorio	Faltó a 2 prácticas	2025-03-15	Dr. López	50
22	22	26	18.86	Final	Participación activa en clase	2025-03-18	Ing. Díaz	15
23	23	3	15.11	Sustitutorio	Recuperación aprobada	2025-03-30	Dr. Torres	6
24	24	9	10.48	Final	Participación activa en clase	2025-04-04	Dr. López	5
25	25	3	10.08	Final	Faltó a 2 prácticas	2025-04-18	Dra. León	12
26	26	2	10.63	Sustitutorio	Buen desempeño en el examen	2025-04-20	Lic. Romero	50
27	27	15	12.59	Parcial	Necesita reforzar	2025-04-22	Dra. Navarro	48
28	28	11	17.17	Sustitutorio	Recuperación aprobada	2025-04-23	Ing. Díaz	35
29	29	30	11.75	Sustitutorio	Buen desempeño en el examen	2025-04-24	Ing. Díaz	40
30	30	22	16.78	Sustitutorio	Recuperación aprobada	2025-04-27	Lic. Mendoza	19
31	31	28	9.17	Sustitutorio	Examen perfecto	2025-05-02	Dra. Navarro	2
32	32	24	18.82	Sustitutorio	Buen desempeño en el examen	2025-05-08	Dr. Sánchez	18
33	33	25	18.76	Sustitutorio	Buen desempeño en el examen	2025-05-14	Ing. Bravo	6
34	34	13	14.87	Parcial	Participación activa en clase	2025-05-15	Lic. Campos	40
35	35	21	15.72	Parcial	Buena mejora	2025-05-17	Dr. Ramírez	40
36	36	26	12.29	Sustitutorio	Necesita reforzar	2025-05-24	Ing. Chávez	2
37	37	6	8.63	Parcial	Desempeño bajo	2025-05-26	Dr. Ramírez	7
38	38	21	10.61	Final	Buen desempeño en el examen	2025-05-30	Ing. Bravo	21
39	39	4	15.29	Parcial	Buen desempeño en el examen	2025-06-08	Dr. Ramírez	37
40	40	12	10.74	Final	Cumplió con todos los criterios	2025-06-10	Dr. Ramírez	32
41	41	6	13.18	Sustitutorio	Desempeño bajo	2025-06-11	Ing. Chávez	27
42	42	24	8.81	Sustitutorio	Desempeño bajo	2025-06-17	Dr. López	13
43	43	26	18.97	Sustitutorio	Faltó a 2 prácticas	2025-06-20	Ing. Bravo	25
44	44	15	12.16	Sustitutorio	Desempeño bajo	2025-06-22	Dr. Sánchez	10
45	45	26	17.94	Sustitutorio	Recuperación aprobada	2025-06-24	Dr. Sánchez	21
46	46	26	11.24	Final	Cumplió con todos los criterios	2025-06-28	Dra. León	7
47	47	15	18.74	Parcial	Examen perfecto	2025-06-30	Dra. Rojas	35
48	48	25	17.64	Parcial	Recuperación aprobada	2025-07-02	Dr. Ramírez	38
49	49	8	11.53	Final	Desempeño bajo	2025-07-04	Lic. Mendoza	49
50	50	30	9.28	Sustitutorio	Examen perfecto	2025-07-06	Ing. Chávez	11
51	51	10	10.82	Sustitutorio	Faltó a 2 prácticas	2025-07-09	Dr. López	46
52	52	14	12.59	Parcial	Desempeño bajo	2025-07-12	Ing. Bravo	39
53	53	24	10.29	Parcial	Cumplió con todos los criterios	2025-07-19	Lic. Romero	6
54	54	21	8.28	Sustitutorio	Examen perfecto	2025-07-20	Dr. López	43
55	55	21	9.23	Final	Buen desempeño en el examen	2025-07-26	Dra. Navarro	9
56	56	21	8.71	Sustitutorio	Faltó a 2 prácticas	2025-07-28	Lic. Mendoza	38
57	57	14	15.37	Final	Faltó a 2 prácticas	2025-07-29	Dra. Rojas	15
58	58	3	19.57	Final	Recuperación aprobada	2025-08-03	Lic. Huamán	28
59	59	24	11.33	Parcial	Cumplió con todos los criterios	2025-08-09	Lic. Huamán	4
60	60	12	16.09	Final	Necesita reforzar	2025-08-15	Dra. Navarro	7
61	61	23	12.78	Parcial	Necesita reforzar	2025-08-19	Dr. Sánchez	6
62	62	18	19.79	Final	Necesita reforzar	2025-08-24	Ing. Bravo	6
63	63	29	17.99	Sustitutorio	Desempeño bajo	2025-08-25	Dr. López	11
64	64	29	16.05	Final	Buen desempeño en el examen	2025-08-27	Lic. Mendoza	1
65	65	21	14.23	Sustitutorio	Necesita reforzar	2025-08-30	Lic. Mendoza	34
66	66	8	11.10	Sustitutorio	Le falto Poco	2025-08-31	Dra. Rojas	3
67	67	6	10.02	Final	Buen desempeño en el examen	2025-09-10	Lic. Huamán	21
68	68	29	10.02	Parcial	Recuperación aprobada	2025-09-16	Dr. Torres	3
69	69	23	17.88	Parcial	Cumplió con todos los criterios	2025-09-20	Lic. Mendoza	3
70	70	20	17.73	Final	Examen perfecto	2025-09-24	Dr. Sánchez	43
71	71	29	13.66	Sustitutorio	Necesita reforzar	2025-09-25	Dr. Ramírez	50
72	72	23	16.40	Parcial	Recuperación aprobada	2025-09-28	Lic. Huamán	44
73	73	16	10.25	Sustitutorio	Buen desempeño en el examen	2025-09-29	Dr. Ramírez	4
74	74	26	16.56	Sustitutorio	Examen perfecto	2025-09-30	Dra. Navarro	6
75	75	2	15.20	Final	Buena mejora	2025-10-04	Dra. Navarro	4
76	76	21	11.43	Final	Recuperación aprobada	2025-10-10	Dra. León	44
77	77	12	10.41	Sustitutorio	Participación activa en clase	2025-10-11	Lic. Campos	17
78	78	16	15.49	Sustitutorio	Faltó a 2 prácticas	2025-10-15	Lic. Campos	4
79	79	7	11.53	Parcial	Recuperación aprobada	2025-10-16	Lic. Mendoza	41
80	80	12	14.05	Sustitutorio	Examen perfecto	2025-10-19	Lic. Mendoza	1
81	81	2	17.20	Parcial	Examen perfecto	2025-10-22	Ing. Chávez	26
82	82	12	10.68	Parcial	Examen perfecto	2025-10-23	Dr. Torres	17
83	83	13	17.63	Final	Buen desempeño en el examen	2025-10-25	Dr. Sánchez	34
84	84	13	9.23	Sustitutorio	Faltó a 2 prácticas	2025-10-26	Lic. Campos	11
85	85	29	8.30	Sustitutorio	Necesita reforzar	2025-10-30	Dra. Navarro	19
86	86	20	16.84	Parcial	Necesita reforzar	2025-11-03	Ing. Chávez	21
87	87	6	13.24	Sustitutorio	Examen perfecto	2025-11-07	Lic. Huamán	36
88	88	19	14.23	Parcial	Buena mejora	2025-11-11	Ing. Chávez	29
89	89	24	18.10	Final	Buena mejora	2025-11-15	Dr. Torres	24
90	90	20	11.70	Sustitutorio	Desempeño bajo	2025-11-16	Lic. Romero	22
91	91	18	11.99	Sustitutorio	Buen desempeño en el examen	2025-11-19	Dra. Navarro	29
92	92	28	16.46	Sustitutorio	Necesita reforzar	2025-11-22	Ing. Bravo	7
93	93	20	15.32	Parcial	Buena mejora	2025-11-23	Dr. Torres	50
94	94	19	13.55	Sustitutorio	Recuperación aprobada	2025-11-26	Dr. Torres	28
95	95	18	13.59	Parcial	Participación activa en clase	2025-12-07	Ing. Díaz	14
96	96	29	18.66	Final	Desempeño bajo	2025-12-14	Ing. Díaz	3
97	97	12	10.84	Parcial	Participación activa en clase	2025-12-21	Ing. Chávez	35
98	98	3	9.93	Parcial	Participación activa en clase	2025-12-23	Dr. Torres	43
99	99	16	18.71	Sustitutorio	Examen perfecto	2025-12-26	Ing. Chávez	37
100	100	1	9.63	Sustitutorio	Desempeño bajo	2025-12-28	Dra. Navarro	49
101	101	21	15.00	Parcial	Mejorar que aun puede	2025-01-13	Ing.Torres	1
\.


--
-- TOC entry 4911 (class 0 OID 0)
-- Dependencies: 217
-- Name: cursos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cursos_id_seq', 30, true);


--
-- TOC entry 4912 (class 0 OID 0)
-- Dependencies: 219
-- Name: notas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notas_id_seq', 1, false);


--
-- TOC entry 4752 (class 2606 OID 16406)
-- Name: cursos cursos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cursos
    ADD CONSTRAINT cursos_pkey PRIMARY KEY (id);


--
-- TOC entry 4754 (class 2606 OID 16427)
-- Name: notas notas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notas
    ADD CONSTRAINT notas_pkey PRIMARY KEY (id);


-- Completed on 2025-07-19 12:16:35

--
-- PostgreSQL database dump complete
--

