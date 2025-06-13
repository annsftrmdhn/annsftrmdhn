
import streamlit as st
import pandas as pd
import plotly.express as px
from sklearn.linear_model import LogisticRegression
from sklearn.impute import SimpleImputer

# ----------------- Setup -------------------
st.set_page_config(
    page_title="Stroke Awareness Dashboard",
    page_icon="🧠",
    layout="wide",
    initial_sidebar_state="expanded"
)

st.markdown("""
<style>
    /* Judul besar */
    h1 {
        font-size: 3rem !important;
        color: #003366;
        font-weight: 700;
    }
    h2 {
        font-size: 2.5rem !important;
        color: #003366;
    }
    h3 {
        font-size: 2rem !important;
        color: #004080;
    }
    /* Teks biasa */
    .css-1d391kg p, .css-1d391kg span {
        font-size: 1.25rem !important;
        color: #333333;
    }
    /* Label input dan select box */
    label {
        font-size: 1.1rem !important;
        font-weight: 600;
    }
    /* Tombol */
    .stButton>button {
        font-size: 1.2rem !important;
        padding: 10px 25px;
        background-color: #0073e6;
        color: white;
        border-radius: 8px;
        font-weight: bold;
    }
</style>
""", unsafe_allow_html=True)

# Judul dan deskripsi utama
st.title("🧠 Stroke Awareness Dashboard")
st.write("Mari kita tingkatkan kesadaran tentang stroke dengan data dan prediksi berbasis AI. Yuk, jaga kesehatan otak kita bersama!")

# Tombol di kanan atas dengan kolom
col_left, col_right = st.columns([9,1])
with col_right:
    if not st.session_state.get('show_prediksi', False):
        if st.button("🩺 Mulai Prediksi"):
            st.session_state['show_prediksi'] = True

# Inisialisasi state jika belum ada
if 'show_prediksi' not in st.session_state:
    st.session_state['show_prediksi'] = False

# Load data dan model
@st.cache_data
def load_data():
    data = pd.read_csv("healthcare-dataset-stroke-data (1).csv")
    data = data.drop(columns=["id"])
    return data

data_raw = load_data()

@st.cache_resource
def prepare_model():
    df = data_raw.dropna()
    df_encoded = pd.get_dummies(df, drop_first=True)
    X = df_encoded.drop("stroke", axis=1)
    y = df_encoded["stroke"]
    imputer = SimpleImputer(strategy="mean")
    X_imputed = pd.DataFrame(imputer.fit_transform(X), columns=X.columns)
    model = LogisticRegression(max_iter=500)
    model.fit(X_imputed, y)
    return model, imputer, X.columns

model, imputer, feature_cols = prepare_model()

# Fungsi encode input
def encode_input(age, avg_glucose, bmi, gender, hypertension, heart_disease,
                 ever_married, work_type, residence_type, smoking_status):
    data = {
        "age": age,
        "avg_glucose_level": avg_glucose,
        "bmi": bmi,
        "gender_Male": 1 if gender == "Male" else 0,
        "hypertension": 1 if hypertension == "Ya" else 0,
        "heart_disease": 1 if heart_disease == "Ya" else 0,
        "ever_married_Yes": 1 if ever_married == "Ya" else 0,
        "work_type_Govt_job": 1 if work_type == "Govt_job" else 0,
        "work_type_Never_worked": 1 if work_type == "Never_worked" else 0,
        "work_type_Private": 1 if work_type == "Private" else 0,
        "work_type_Self-employed": 1 if work_type == "Self-employed" else 0,
        "work_type_children": 1 if work_type == "children" else 0,
        "Residence_type_Urban": 1 if residence_type == "Urban" else 0,
        "smoking_status_formerly smoked": 1 if smoking_status == "formerly smoked" else 0,
        "smoking_status_never smoked": 1 if smoking_status == "never smoked" else 0,
        "smoking_status_smokes": 1 if smoking_status == "smokes" else 0,
        "smoking_status_Unknown": 1 if smoking_status == "Unknown" else 0
    }
    df = pd.DataFrame([data])
    for col in feature_cols:
        if col not in df.columns:
            df[col] = 0
    df = df[feature_cols]
    df = pd.DataFrame(imputer.transform(df), columns=feature_cols)
    return df

# Konten utama
if st.session_state['show_prediksi']:
    st.markdown("---")
    st.header("🩺 Form Prediksi Risiko Stroke")

    with st.form("stroke_form", clear_on_submit=False):
        col1, col2, col3 = st.columns(3)
        with col1:
            gender = st.selectbox("Jenis Kelamin", ["Female", "Male"])
            age = st.slider("Umur", 0, 120, 30)
            hypertension = st.selectbox("Hipertensi", ["Tidak", "Ya"])
        with col2:
            heart_disease = st.selectbox("Penyakit Jantung", ["Tidak", "Ya"])
            ever_married = st.selectbox("Pernah Menikah", ["Tidak", "Ya"])
            work_type = st.selectbox("Jenis Pekerjaan", ["Govt_job", "Never_worked", "Private", "Self-employed", "children"])
        with col3:
            residence_type = st.selectbox("Tipe Tempat Tinggal", ["Rural", "Urban"])
            avg_glucose = st.number_input("Rata-rata Glukosa", min_value=0.0, max_value=500.0, value=100.0, step=0.1)
            bmi = st.number_input("BMI", min_value=0.0, max_value=100.0, value=22.0, step=0.1)
        smoking_status = st.selectbox("Status Merokok", ["Unknown", "formerly smoked", "never smoked", "smokes"])

        submit = st.form_submit_button("🔍 Prediksi Risiko")

    if submit:
        input_encoded = encode_input(age, avg_glucose, bmi, gender, hypertension,
                                     heart_disease, ever_married, work_type,
                                     residence_type, smoking_status)
        prob = model.predict_proba(input_encoded)[0][1]
        pred = model.predict(input_encoded)[0]

        st.markdown("### Hasil Prediksi")
        st.write(f"**Risiko Stroke:** {'⚠️ Tinggi' if pred == 1 else '✅ Rendah'}")
        st.progress(int(prob * 100))
        st.write(f"**Probabilitas:** {prob:.2%}")

        if prob > 0.5:
            st.warning("🚨 Hasil ini menunjukkan risiko tinggi. Segera konsultasi dengan dokter, ya!")
        else:
            st.success("🎉 Risiko stroke tergolong rendah. Terus jaga pola hidup sehat!")

        # Tombol kembali ke dashboard
        if st.button("🔙 Kembali ke Dashboard"):
            st.session_state['show_prediksi'] = False
            st.experimental_rerun()

else:
    st.header("📊 Visualisasi Faktor Risiko Stroke")
    st.markdown("""
    Yuk, intip grafik dan insight tentang faktor-faktor yang mempengaruhi risiko stroke. Dengan data ini, kamu bisa lebih paham bagaimana menjaga kesehatan otak dan tubuhmu supaya tetap prima! 💪🧠
    """)

    with st.container():
        st.markdown('<div class="viz-container">', unsafe_allow_html=True)

        fig_age = px.histogram(data_raw, x="age", color="stroke", barmode="overlay",
                               color_discrete_map={0: 'skyblue', 1: 'orangered'},
                               title="Distribusi Umur dan Risiko Stroke")
        fig_age.update_layout(
                                    xaxis_title="Umur")
        st.plotly_chart(fig_age, use_container_width=True)
        st.write("📈 Usia memegang peranan penting dalam risiko stroke. Lihat bagaimana distribusinya!")

        fig_glucose = px.histogram(data_raw, x="avg_glucose_level", color="stroke", barmode="overlay",
                                   color_discrete_map={0: 'skyblue', 1: 'orangered'},
                                   title="Distribusi Glukosa dan Risiko Stroke")
        fig_glucose.update_layout(
                                    xaxis_title="Rata-rata Glukosa Level")
        st.plotly_chart(fig_glucose, use_container_width=True)
        st.write("🩸 Kadar glukosa darah yang tinggi dapat meningkatkan risiko stroke. Yuk, perhatikan pola makanmu!")

        fig_bmi = px.histogram(data_raw, x="bmi", color="stroke", barmode="overlay",
                               color_discrete_map={0: 'skyblue', 1: 'orangered'},
                               title="Distribusi BMI dan Risiko Stroke")
        fig_bmi.update_layout(
                                    xaxis_title="BMI")
        st.plotly_chart(fig_bmi, use_container_width=True)
        st.write("⚖️ BMI juga penting! Jaga berat badan ideal agar risiko stroke bisa ditekan.")

        fig_smoke = px.bar(data_raw.groupby("smoking_status")["stroke"].mean().reset_index(),
                           x="smoking_status", y="stroke",
                           color="stroke",
                           title="Proporsi Stroke Berdasarkan Status Merokok",
                           labels={"stroke": "Proporsi Stroke"},
                           color_discrete_sequence=["orangered"])
        fig_smoke.update_layout(
                                    xaxis_title="Kebiasaan Merokok")
        st.plotly_chart(fig_smoke, use_container_width=True)
        st.write("🚭 Merokok dapat meningkatkan risiko stroke. Saatnya berhenti demi masa depan sehatmu!")

        st.markdown('</div>', unsafe_allow_html=True)

