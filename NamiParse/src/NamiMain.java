import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JSplitPane;
import javax.swing.JTextArea;
import javax.swing.UIManager;
import javax.swing.WindowConstants;

public class NamiMain extends JPanel {

	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			@Override
			public void run() {
				createAndShowGUI();
			}
		});
	}

	public static void createAndShowGUI() {
		try {
			UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
		} catch (Exception e) {
			e.printStackTrace();
		}
		JFrame frame = new JFrame("JNami");
		frame.setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
		frame.getContentPane().add(new NamiMain());
		frame.pack();
		frame.setLocationRelativeTo(null);
		frame.setVisible(true);
	}

	JTextArea j1 = new JTextArea();
	JTextArea j2 = new JTextArea();
	
	public NamiMain() {
		super(new BorderLayout());
		add(new JSplitPane(JSplitPane.VERTICAL_SPLIT, new JScrollPane(j1), new JScrollPane(j2)));
        setPreferredSize(new Dimension(320, 240));
	}

}
